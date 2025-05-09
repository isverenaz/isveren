<?php

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobContact;
use App\Models\User;
use App\Notifications\Mail;
use App\Repositories\PermissionRepositoryImpl;
use App\Repositories\RoleRepositoryImpl;
use App\Repositories\UserRepositoryImpl;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(UserRepositoryImpl $userRepository, RoleRepositoryImpl $roleRepository, PermissionRepositoryImpl $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }


    public function register(){
        return view('web.users.auth.register');
    }
    public function userRegisterAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'name_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users',new PhoneNumber],
            'password' => ['required'],
            'captcha' => ['required'],
        ],[
            'name_surname.required' => 'Zəhmət olmasa ad və soyadı qeyd edin',
            'phone.required' => 'Zəhmət olmasa əlaqə nömrəsi  qeyd edin',
            'phone.unique' => 'Əlaqə nömrəsi artıq qeydiyyatda vardır',
            'email.unique' => 'E-poçt  artıq qeydiyyatda vardır',
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
            'captcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'errors' => $valdate->messages()
            ]);
        }

        try {
            $captcha = self::verifyCaptcha($request->captcha);
            if (!$captcha)
            {
                return response()->json([
                    'success' => false,
                    'errors' => 'Qeyd etdiyiniz simvolar doğru deyildir.'
                ]);
            }
            $name_surname = $request->name_surname;
            $name_surname = explode(" ", $name_surname);

            $name = $name_surname[0];
            $surname = $name_surname[1] ?? $name_surname[0];

            $userData = [
                'name' => $name,
                'surname' => $surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'status' => 1
            ];

            $user = $this->userRepository->create($userData);
            if ($user) {
                $roles = $this->roleRepository->findBySlug('users');
                $user->roles()->attach($roles);
            }
            $userActive = User::with('userRole')->where(['id'=>$user->id,'status'=>1])->first();
            if ($userActive) {
                auth('web')->login($userActive);
                if (!empty(auth()->guard('web')->user()->userRole->role) && in_array($userActive->userRole->role->slug,['users','admin']))
                {
                    $message =  "Qeydiyyatdan uğurla keçdiniz. Daxil olmaq üçün giriş səhifədə e-poçt və şifrəni qeyd edib daxil olun.";
                    return   ['success' => true, 'message' => $message, 'redirect' => url('/user/account')];
                }else{
                    return response()->json([
                        'success' => false,'errors' => 'Xəta baş verdi: ' . Lang::get('web.register_error')]);
                }
            }else{
                return response()->json([
                    'success' => false,'errors' => 'Xəta baş verdi: ' . Lang::get('web.register_error')]);
            }
            $message =  "Qeydiyyatdan uğurla keçdiniz. Daxil olmaq üçün giriş səhifədə e-poçt və şifrəni qeyd edib daxil olun.";
            /*$mail_data = [
                'title' => 'Hesabın təsdiq edilməsi',
                'subject' => $message,
                'email' => $request->email,
                'password' => $request->password,
                'url' => 'https://isveren.az/register/user-activity/'.$user->id
            ];*/
            //Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
            return   ['success' => true, 'message' => $message, 'redirect' => url('/user/account')];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,'errors' => 'Xəta baş verdi: ' . $e->getMessage()]);
        }
    }

    public function companyRegisterAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'name_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users',new PhoneNumber],
            'password' => ['required'],
            'companyCaptcha' => ['required'],
        ],[
            'name_surname.required' => 'Zəhmət olmasa ad və soyadı qeyd edin',
            'phone.required' => 'Zəhmət olmasa əlaqə nömrəsi  qeyd edin',
            'phone.unique' => 'Əlaqə nömrəsi artıq qeydiyyatda vardır',
            'email.unique' => 'E-poçt  artıq qeydiyyatda vardır',
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
            'companyCaptcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'errors' => $valdate->messages()
            ]);
        }

        try {
            $captcha = self::verifyCaptcha($request->companyCaptcha);
            if (!$captcha)
            {
                return response()->json([
                    'success' => false,
                    'errors' => 'Qeyd etdiyiniz simvolar doğru deyildir.'
                ]);
            }

            $name_surname = $request->name_surname;
            $name_surname = explode(" ", $name_surname);

            $name = $name_surname[0];
            $surname = $name_surname[1] ?? $name_surname[0];
            $userData = [
                'name' => $name,
                'surname' => $surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'status' => 1
            ];

            $user = $this->userRepository->create($userData);
            if ($user) {
                $roles = $this->roleRepository->findBySlug('company');
                $user->roles()->attach($roles);
            }
            $userActive = User::with('userRole')->where(['id'=>$user->id,'status'=>1])->first();
            if ($userActive) {
                auth('web')->login($userActive);
                if (!empty(auth()->guard('web')->user()->userRole->role) && in_array($userActive->userRole->role->slug,['company','admin']))
                {
                    $message =  "Qeydiyyatdan uğurla keçdiniz. Daxil olmaq üçün giriş səhifədə e-poçt və şifrəni qeyd edib daxil olun.";
                    return   ['success' => true, 'message' => $message, 'redirect' => url('/user/account')];
                }else{
                    return response()->json([
                        'success' => false,'errors' => 'Xəta baş verdi: ' . Lang::get('web.register_error')]);
                }
            }else{
                return response()->json([
                    'success' => false,'errors' => 'Xəta baş verdi: ' . Lang::get('web.register_error')]);
            }
            $message =  "Qeydiyyatdan uğurla keçdiniz. Daxil olmaq üçün giriş səhifədə e-poçt və şifrəni qeyd edib daxil olun.";
            /*$mail_data = [
                'title' => 'Hesabın təsdiq edilməsi',
                'subject' => $message,
                'email' => $request->email,
                'password' => $request->password,
                'url' => 'https://isveren.az/register/company-activity/'.$user->id
            ];
            Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));*/
            return   ['success' => true, 'message' => $message, 'redirect' => url('/user/account')];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,'errors' => 'Xəta baş verdi: ' . $e->getMessage()]);
        }
    }
   /* public function userRegisterAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'name_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users',new PhoneNumber],
            'password' => ['required'],
            'captcha' => ['required'],
        ],[
            'name_surname.required' => 'Zəhmət olmasa ad və soyadı qeyd edin',
            'phone.required' => 'Zəhmət olmasa əlaqə nömrəsi  qeyd edin',
            'phone.unique' => 'Əlaqə nömrəsi artıq qeydiyyatda vardır',
            'email.unique' => 'E-poçt  artıq qeydiyyatda vardır',
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
            'captcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'error' => $valdate->messages()
            ]);
        }

        try {
            $captcha = self::verifyCaptcha($request->captcha);
            if (!$captcha)
            {
                return response()->json([
                    'success' => false,
                    'error' => ['Qeyd etdiyiniz simvolar doğru deyildir.']
                ]);
            }
            $name_surname = $request->name_surname;
            $name_surname = explode(" ", $name_surname);

            $name = $name_surname[0];
            $surname = $name_surname[1] ?? $name_surname[0];

            $userData = [
                'name' => $name,
                'surname' => $surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'status' => 1
            ];

            $user = $this->userRepository->create($userData);
            if ($user) {
                $roles = $this->roleRepository->findBySlug('users');
                $user->roles()->attach($roles);
            }
            $message =  "Zəhmət olmasa hesabınıza daxil olmaq üçün təsdiq edin";
            $mail_data = [
                'title' => 'Hesabın təsdiq edilməsi',
                'subject' => $message,
                'email' => $request->email,
                'password' => $request->password,
                'url' => 'https://isveren.az/register/user-activity/'.$user->id
            ];
            Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
            return   ['success' => true, 'message' => $message];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,'error' => ['Xəta baş verdi: ' . $e->getMessage()]]);
        }
    }

    public function companyRegisterAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'name_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users',new PhoneNumber],
            'password' => ['required'],
            'companyCaptcha' => ['required'],
        ],[
            'name_surname.required' => 'Zəhmət olmasa ad və soyadı qeyd edin',
            'phone.required' => 'Zəhmət olmasa əlaqə nömrəsi  qeyd edin',
            'phone.unique' => 'Əlaqə nömrəsi artıq qeydiyyatda vardır',
            'email.unique' => 'E-poçt  artıq qeydiyyatda vardır',
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
            'companyCaptcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'error' => $valdate->messages()
            ]);
        }

        try {
            $captcha = self::verifyCaptcha($request->companyCaptcha);
            if (!$captcha)
            {
                return response()->json([
                    'success' => false,
                    'error' => ['Qeyd etdiyiniz simvolar doğru deyildir.']
                ]);
            }

            $name_surname = $request->name_surname;
            $name_surname = explode(" ", $name_surname);

            $name = $name_surname[0];
            $surname = $name_surname[1] ?? $name_surname[0];
            $userData = [
                'name' => $name,
                'surname' => $surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'status' => 1
            ];

            $user = $this->userRepository->create($userData);
            if ($user) {
                $roles = $this->roleRepository->findBySlug('company');
                $user->roles()->attach($roles);
            }
            $message =  "Zəhmət olmasa hesabınıza daxil olmaq üçün təsdiq edin";
            $mail_data = [
                'title' => 'Hesabın təsdiq edilməsi',
                'subject' => $message,
                'email' => $request->email,
                'password' => $request->password,
                'url' => 'https://isveren.az/register/company-activity/'.$user->id
            ];
            Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
            return   ['success' => true, 'message' => $message];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,'error' => ['Xəta baş verdi: ' . $e->getMessage()]]);
        }
    }*/

    public function userStatus($id)
    {
        $user = User::where(['id'=>$id,'status'=>0])->first();
        if (empty($user->id))
        {
            return back()->with('error', 'Hesab tapılmadı');
        }
        $up = User::where(['id'=>$id,'status'=>0])->update(['status' => 1]);
        if ($up)
        {
            $userActive = User::with('userRole')->where(['id'=>$id,'status'=>1])->first();
            if ($userActive) {
                auth('web')->login($userActive);
                if (!empty(auth()->guard('web')->user()->userRole->role) && in_array($userActive->userRole->role->slug,['users','admin']))
                {
                    return redirect(route('web.user.dashboard'))->with('success', Lang::get('web.register_success'));
                }else{
                    return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
                }
            }else{
                return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
            }
        }else{
            return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
        }
    }
    public function companyStatus($id)
    {
        $user = User::where(['id'=>$id,'status'=>0])->first();
        if (empty($user->id))
        {
            return back()->with('error', 'Hesab tapılmadı');
        }
        $up = User::where(['id'=>$id,'status'=>0])->update(['status' => 1]);
        if ($up)
        {
            $userActive = User::with('userRole')->where(['id'=>$id,'status'=>1])->first();
            if ($userActive) {
                auth('web')->login($userActive);
                if (!empty(auth()->guard('web')->user()->userRole->role) && in_array($userActive->userRole->role->slug,['company','admin']))
                {
                    return redirect(route('web.user.dashboard'))->with('success', Lang::get('web.register_success'));
                }else{
                    return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
                }
            }else{
                return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
            }
        }else{
            return redirect(route('web.register'))->with('errors', Lang::get('web.register_error'));
        }
    }

    public function login(){
        return view('web.users.auth.login');
    }
    public function userLoginAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
//            'captcha' => ['required']
        ],[
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
//            'captcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'errors' => $valdate->messages()
            ]);
        }
       /* $captcha = $request->captcha;
        $captcha = self::verifyCaptcha($captcha);
        if (!$captcha)
        {
            return response()->json([
                'success' => false,
                'error' => ['Qeyd etdiyiniz simvolar doğru deyildir.']
            ]);
        }*/

        $user  = User::with('userRole')->where(['email'=>$request->email,'status' => 1])->first();
        if (empty($user->id))
        {
            return response()->json([
                'success' => false,
                'errors' => 'Qeyd etdiyiniz e-poçta uyğun hesab tapılmadı']);
        }
        $loginState = ['email' => $request->email,'password' => $request->password];
        if (auth('web')->attempt($loginState)) {
            if (!empty(auth()->guard('web')->user()->userRole->role)  && in_array($user->userRole->role->slug,['users','admin']))
            {
                $response = [
                    'success' => true,
                    'message' => 'Daxil olundu',
                    'redirect' => url('/user/account')
                ];
            }else{
                return response()->json([
                    'success' => false,
                    'errors' => 'Qeyd etdiyiniz e-poçta şirkət hesab hesabı üçündür.']);
            }

            return $response;
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Login və ya şifrə düzgün deyil'
            ]);
        }
    }

    public function companyLoginAccept(Request $request)
    {
        $valdate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
//            'captcha' => ['required']
        ],[
            'email.required' => 'Zəhmət olmasa e-poçtunuzu qeyd edin',
            'password.required' => 'Zəhmət olmasa şifrənizi qeyd edin',
//            'captcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
        ]);
        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'errors' => $valdate->messages()
            ]);
        }
        /*$captcha = $request->captcha;
        $captcha = self::verifyCaptcha($captcha);
        if (!$captcha)
        {
            return response()->json([
                'success' => false,
                'error' => ['Qeyd etdiyiniz simvolar doğru deyildir.']
            ]);
        }*/
        $user  = User::with('userRole')->where(['email'=>$request->email,'status' => 1])->first();
        if (empty($user->id))
        {
            return response()->json([
                'success' => false,
                'errors' => 'Qeyd etdiyiniz e-poçta uyğun hesab tapılmadı']);
        }
        $loginState = ['email' => $request->email,'password' => $request->password];
        if (auth('web')->attempt($loginState)) {
            if (!empty(auth()->guard('web')->user()->userRole->role)  && in_array($user->userRole->role->slug,['company','admin']))
            {
                return [
                    'success' => true,
                    'message' => 'Daxil olundu',
                    'redirect' => url('/user/account')
                ];
            }else{
                return response()->json([
                    'success' => false,
                    'errors' => 'Qeyd etdiyiniz e-poçta istifadəçi hesabı üçündür']);
            }
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Login və ya şifrə düzgün deyil'
            ]);
        }
    }


    public function generateCaptcha()
    {
        // Rastgele 6 karakterli CAPTCHA kodu oluştur
        $captchaCode = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
        // CAPTCHA kodunu session'a kaydet
        Session::put('captcha', $captchaCode);
        // CAPTCHA resmi oluştur
        $image = imagecreate(120, 40);
        // Arxa fon rəngini #22ca46 (yaşıl) et
        $bgColor = imagecolorallocate($image, 34, 202, 70);
        // Mətn rəngini ağ et ki, oxunaqlı olsun
        $textColor = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 5, 30, 10, $captchaCode, $textColor);
        // Resmi tarayıcıya PNG formatında gönder
        header("Content-type: image/png");
        imagepng($image);
        imagedestroy($image);
    }

    public static function verifyCaptcha($captcha)
    {
        // Session'daki doğru CAPTCHA kodu
        $storedCaptcha = Session::get('captcha');
        if ($captcha === $storedCaptcha) {
            return true;
        } else {
            return false;
        }
    }

    public function forget_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $user  = User::where(['email'=>$request->email])->first();

        if (empty($user))
            $mail_data = [
                'mail' => $user->email,
                'url' => config('app.frontend_url') . '/edit-password/',
                'name' => $user->name,
                'surname' => $user->surname,
                'dedicated'=>'forget_password'
            ];


        Notification::route('mail', $mail_data['mail'])->notify(new Mail($mail_data));
    }

    public function jobContact(Request $request)
    {
        $user = auth()->guard('web')->user();
        if (empty($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Zəhmət olmasa müraciət üçün kabnetinizi aktivləşdirin.',
            ]);
        }
        $valdate = Validator::make($request->all(), [
            'fullname' => ['required', 'string', 'max:255'],
            'messages' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255', new PhoneNumber],
            'resume' => [ 'required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ], [
            'fullname.required' => 'Ad və Soyad boş olmamalıdır',
            'messages.required' => 'Motivasiya mektubu boş olmamalıdır',
            'phone.required' => 'Əlaqə nömrəsi boş olmamalıdır',
            'email.required' => 'E-poçt boş olmamalıdır',
            'resume.required' => 'CV boş olmamalıdır',
            'resume.file' => 'CV fayl formatında olmalıdır',
            'resume.mimes' => 'CV yalnız PDF, DOC və ya DOCX formatında ola bilər',
            'resume.max' => 'CV maksimum 2MB olmalıdır',
        ]);

        if ($valdate->fails())
        {
            return response()->json([
                'success' => false,
                'error' => $valdate->messages()
            ]);
        }

        try {
            $jobContact = JobContact::where(['job_id' => $request->company_id, 'job_id' => $request->job_id, 'user_id' => $user->id])->first();
            if (!empty($jobContact['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siz artıq bir dəfə müraciət etmisiniz.',
                ]);
            }
            $job = Job::where(['id' => $request->job_id, 'status' => 1])->first();
            if (empty($job['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Müraciət üçün vaxt bitmişdir',
                ]);
            }
            if ($request->hasFile('resume')) {
                $resume = time() . '.' . $request->resume->extension();
                $request->resume->move(public_path('uploads/job-contact'), $resume);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => ['resume' => 'CV faylı yüklənə bilmədi. Zəhmət olmasa təkrar yoxlayın.']
                ]);
            }

            $data = [
                'company_id' => $request->company_id ?? 2,
                'job_id' => $request->job_id,
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'messages' => $request->messages,
                'resume' => $resume,
                'send_date' => Carbon::now(),
                'status' => 0
            ];

            JobContact::create($data);
           /* $companyMessage =  "Zəhmət olmasa ".$request->fullname." tərəfindən ". json_decode($job, true)['title']['az'] ."- iş elana göndərilən cv-ə baxış keçirin.";
            $mail_data = [
                'title' => json_decode($job, true)['title']['az'] ."- iş elana gələn müraciətə",
                'subject' => $companyMessage,
                'email' => $request->email,
                'phone' => $request->phone,
                'resume' => $resume,
                'send_date' => Carbon::now()
            ];
            Notification::route('mail', $job['email'])->notify(new Mail($mail_data));*/
            $userMessage = 'Müraciətiniz uğurla tamamlandı.';

            return   ['success' => true, 'message' => $userMessage];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi. Zəhmət olmasa yenidən yoxlayın.'.$e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        \Session::flush();
        \auth()->guard('web')->logout();
        return redirect(route('web.home'));
    }
}
