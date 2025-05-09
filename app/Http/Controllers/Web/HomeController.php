<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Cv;
use App\Models\Job;
use App\Models\StaticPage;
use App\Models\User;
use App\Models\Category;
use App\Models\City;
use App\Models\Follower;
use App\Models\JobType;
use Illuminate\Http\Request;
use App\Services\SEOManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDF;

class HomeController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Alınan kodu yoxlayaq
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'Code not provided'], 400);
        }

        // LinkedIn app-dən məlumatları alırıq
        $clientId = config('services.linkedin.client_id');
        $clientSecret = config('services.linkedin.client_secret');
        $redirectUri = config('services.linkedin.redirect_uri');

        // Access token alma sorğusu
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        // Cavabı alırıq
        $data = $response->json();

        if (isset($data['access_token'])) {
            $expiresIn = $data['expires_in']; // Tokenin ömrünü alırıq
            // Cache-də saxlayırıq
            Cache::put('linkedin_access_token', $data['access_token'], now()->addSeconds($expiresIn));

            // Burada tokeni yadda saxlaya bilərsən
            // Misal üçün database-ə və ya .env faylında
            return response()->json([
                'access_token' => $data['access_token'],
                'expires_in' => $data['expires_in'],
            ]);
        } else {
            // Hata mesajı ilə cavab
            return response()->json($data, 400);
        }
    }
    public function search(Request $request)
    {

        $categoryId = $request->input('categoryId');
        $jobTypeId = $request->input('jobTypeId');
        $citySelect = $request->input('citySelect');
        $saleSelect = $request->input('saleSelect');
        $jobsQuery = Job::where('status', 1);

        $searchParams = $request->only(['categoryId', 'jobTypeId', 'citySelect', 'saleSelect']);


        if ($categoryId) {
            $jobsQuery->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId)
                    ->orWhere('sub_category_id', $categoryId);
            });
        }

        if ($jobTypeId) {
            $jobsQuery->where('job_type_id', $jobTypeId);
        }

        if ($citySelect) {
            $jobsQuery->where('city_id', $citySelect);
        }


        if ($saleSelect) {
            list($minSalary, $maxSalary) = explode('-', $saleSelect);
            $minSalary = intval($minSalary);
            $maxSalary = intval($maxSalary);
            $jobsQuery->where('price', '>=', $minSalary)->where('price', '<=', $maxSalary);
        }

        $jobs = $jobsQuery->orderBy(DB::raw("DATE_FORMAT(start_date, '%m-%d')"), 'DESC')->paginate(5)->appends(request()->query());

        foreach ($searchParams as $key => $value) {
            $jobs->appends([$key => $value]);
        }

        $categories = Category::with('jobCategory', 'subcategory')->where('status', 1)->orderBy('name', 'ASC')->get();
        $jobType = JobType::with('job')->where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::with('city')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();

        return view('web.search', compact('categories', 'jobType', 'jobs', 'cities', 'categoryId', 'jobTypeId', 'citySelect', 'saleSelect'));
    }

    public function home(Request $request)
    {
        $query = Job::query();
        $query->where('status', 1);
        if ($request->filled('search')) {
            $searchTerm = strtolower(request('search'));
            $query->whereRaw('LOWER(title) LIKE ?', ["%$searchTerm%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%$searchTerm%"]);
        }

        if ($request->filled('main_category')) {
            $categoryId = $request->main_category;
            $query->whereHas('jobcategory', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if ($request->filled('parent_category')) {
            $subCategoryId = $request->parent_category;
            $query->whereHas('jobcategory', function ($query) use ($subCategoryId) {
                $query->where('sub_category_id', $subCategoryId);
            });
        }

        if ($request->filled('job_status')) {
            if ($request->job_status == 'is_premium') {
                $query->where('is_premium', 1);
            }elseif ($request->job_status == 'is_new') {
                $query->where('is_new', 1);
            }elseif ($request->job_status == 'is_top') {
                $query->where('is_top', 1);
            }elseif ($request->job_status == 'is_featured') {
                $query->where('is_featured', 1);
            }
        }
        if ($request->filled('short_by')) {
            switch ($request->short_by) {
                case 'is_firts':
                    $query->orderBy('id','DESC'); // ID-ə görə sıralama
                    break;

                case 'is_start_date':
                    $query->orderBy('start_date','DESC'); // start_date-ə görə sıralama
                    break;

                case 'is_name':
                    // JSON sahəsinin içindəki `az` açarına görə sıralama (MySQL 5.7+ üçün uyğundur)
                    $query->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.az'))");
                    break;
                /*default:
                    $query->orderBy('start_date','DESC'); // start_date-ə görə sıralama
                    break;*/
            }
        }

        if ($request->filled('job_type')) {
            $query->whereIn('job_type_id', (array) $request->job_type);
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        $jobs = $query->/*orderBy('start_date', 'DESC')->orderBy('created_at', 'DESC')->*/latest()->paginate(10);
        if ($request->ajax()) {
            $view = view('components.web.job-data', compact('jobs'))->render();
            return response()->json(['html' => $view, 'jobs' => $jobs]);
        }
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        $jobTypes = JobType::with('job')->where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::with('city')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        return view('web.home', compact('jobs','categories', 'jobTypes', 'cities'));
    }

    public function vacancy(Request $request)
    {
        return redirect()->route('web.home');
        $query = Job::query();
        $query->where('status', 1);
        if ($request->filled('search')) {
            $searchTerm = strtolower(request('search'));
            $query->whereRaw('LOWER(title) LIKE ?', ["%$searchTerm%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%$searchTerm%"]);
        }

        if ($request->filled('main_category')) {
            $categoryId = $request->main_category;
            $query->whereHas('jobcategory', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if ($request->filled('parent_category')) {
            $subCategoryId = $request->parent_category;
            $query->whereHas('jobcategory', function ($query) use ($subCategoryId) {
                $query->where('sub_category_id', $subCategoryId);
            });
        }

        if ($request->filled('job_status')) {
            if ($request->job_status == 'is_premium') {
                $query->where('is_premium', 1);
            }elseif ($request->job_status == 'is_new') {
                $query->where('is_new', 1);
            }elseif ($request->job_status == 'is_top') {
                $query->where('is_top', 1);
            }elseif ($request->job_status == 'is_featured') {
                $query->where('is_featured', 1);
            }
        }
        if ($request->filled('short_by')) {
            switch ($request->short_by) {
                case 'is_firts':
                    $query->orderBy('id','DESC'); // ID-ə görə sıralama
                    break;

                case 'is_start_date':
                    $query->orderBy('start_date','DESC'); // start_date-ə görə sıralama
                    break;

                case 'is_name':
                    // JSON sahəsinin içindəki `az` açarına görə sıralama (MySQL 5.7+ üçün uyğundur)
                    $query->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.az'))");
                    break;
                /*default:
                    $query->orderBy('start_date','DESC'); // start_date-ə görə sıralama
                    break;*/
            }
        }

        if ($request->filled('job_type')) {
            $query->whereIn('job_type_id', (array) $request->job_type);
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        $jobs = $query->/*orderBy('start_date', 'DESC')->orderBy('created_at', 'DESC')->*/latest()->paginate(10);
        if ($request->ajax()) {
            $view = view('components.web.job-data', compact('jobs'))->render();
            return response()->json(['html' => $view, 'jobs' => $jobs]);
        }
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        $jobTypes = JobType::with('job')->where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::with('city')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        return view('web.vacancy', compact('jobs','categories', 'jobTypes', 'cities'));
    }

    public function jobDetails($slug, SEOManager $seoManager)
    {
        if (!is_numeric($slug)) {
            $job = Job::with('jobcategory', 'city', 'jobType', 'company')->where('status', 1)->where('code', $slug)->first();
        }else{
            $job = Job::with('jobcategory', 'city', 'jobType', 'company')->where('status', 1)->where('id', $slug)->first();
        }

        if (empty($job)) {
            return redirect(route('web.home'));
        }
        $datas = Job::with('jobcategory', 'city', 'jobType', 'jobUser', 'jobSeo','jobContact')->where('status', 1)->where('company_id', $job->company_id)
            ->orderBy('id', 'DESC')->limit(3)->get();

        $jobData = json_decode($job, true);

        $language = 'az';

        if (isset($jobData['title'][$language])) {
            $title = $jobData['title'][$language] . " | " . $jobData['company']['name'][$language] . " | İşveren.az";

            // $title = iconv('UTF-8', 'ISO-8859-9//TRANSLIT', $title);

            SEOMeta::setTitle(htmlentities($title, ENT_QUOTES, 'UTF-8'));
        }

        if (isset($jobData['description'][$language])) {
            SEOMeta::setDescription($jobData['description'][$language]);
        }

        $viewed = Session::get('reads', []);
        if (!in_array($job->id, $viewed)) {
            $job->increment('reads');
            Session::push('reads', $job->id);
        }
        return view('web.job-details', compact('datas',  'job', 'title'));
    }

    public function about()
    {
        $static_pages = StaticPage::where('type', 'about')->first();
        $category_count =  Category::where('status', 1)->count();
        $job_count = Job::where('status', 1)->count();
        $user_count =  User::where('status', 1)->count();
        $follower_count = Follower::count();
        return view('web.about', compact(['static_pages', 'category_count', 'job_count', 'user_count', 'follower_count']));
    }

    public function professions(Request $request)
    {
        $index = $request->input('index', 'A');
        $search = $request->input('search', '');

        $query = Job::query();

        if ($search) {
            $query->where('title->az', 'like', '%' . $search . '%');
        } else {
            $query->where('title->az', 'like', $index . '%');
        }
        $query->orderBy('created_at', 'desc');

        $jobs = $query->paginate(10);

        return view('web.profession', compact('jobs', 'index'));
    }

    public function companies(Request $request)
    {
        $query = Company::query();
        $query->where('status', 1);
        if ($request->filled('search')) {
            $searchTerm = strtolower(request('search'));
            $query->whereRaw('LOWER(name) LIKE ?', ["%$searchTerm%"])
                ->orWhereRaw('LOWER(address) LIKE ?', ["%$searchTerm%"]);
        }
        $query->orderBy('is_premium','DESC'); // ID-ə görə sıralama
        if ($request->filled('job_status')) {
            if ($request->job_status == 'is_premium') {
                $query->where('is_premium', 1);
            }elseif ($request->job_status == 'is_new') {
                $query->where('is_new', 1);
            }elseif ($request->job_status == 'is_top') {
                $query->where('is_top', 1);
            }elseif ($request->job_status == 'is_featured') {
                $query->where('is_featured', 1);
            }
        }
        if ($request->filled('short_by')) {
            switch ($request->short_by) {
                case 'is_firts':
                    $query->orderBy('id','DESC'); // ID-ə görə sıralama
                    break;
                case 'is_start_date':
                    $query->orderBy('created_at','DESC'); // start_date-ə görə sıralama
                    break;
                case 'is_name':
                    // JSON sahəsinin içindəki `az` açarına görə sıralama (MySQL 5.7+ üçün uyğundur)
                    $query->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az'))");
                    break;
            }
        }

        $companies = $query->latest()->paginate(10);
        if ($request->ajax()) {
            $view = view('components.web.companies-data', compact('companies'))->render();
            return response()->json(['html' => $view, 'companies' => $companies]);
        }
        return view('web.companies', compact('companies'));
    }

    public function companyDetails($id, Request $request)
    {
        $company = Company::where('id', $id)->first();
        $query = Job::query();
        if ($request->filled('search')) {
            $searchTerm = strtolower(request('search'));
            $query->where('company_id', $id)->whereRaw('LOWER(title) LIKE ?', ["%$searchTerm%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%$searchTerm%"]);
        }

        if ($request->filled('main_category')) {
            $categoryId = $request->main_category;
            $query->whereHas('jobcategory', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if ($request->filled('parent_category')) {
            $subCategoryId = $request->parent_category;
            $query->whereHas('jobcategory', function ($query) use ($subCategoryId) {
                $query->where('sub_category_id', $subCategoryId);
            });
        }

        if ($request->filled('job_status')) {
            if ($request->job_status == 'is_premium') {
                $query->where('is_premium', 1);
            }elseif ($request->job_status == 'is_new') {
                $query->where('is_new', 1);
            }elseif ($request->job_status == 'is_top') {
                $query->where('is_top', 1);
            }elseif ($request->job_status == 'is_featured') {
                $query->where('is_featured', 1);
            }
        }
        if ($request->filled('short_by')) {
            switch ($request->short_by) {
                case 'is_firts':
                    $query->orderBy('id','DESC'); // ID-ə görə sıralama
                    break;

                case 'is_start_date':
                    $query->orderBy('start_date','DESC'); // start_date-ə görə sıralama
                    break;

                case 'is_name':
                    // JSON sahəsinin içindəki `az` açarına görə sıralama (MySQL 5.7+ üçün uyğundur)
                    $query->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.az'))");
                    break;
            }
        }

        if ($request->filled('job_type')) {
            $query->whereIn('job_type_id', (array) $request->job_type);
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        $viewed = Session::get('reads', []);
        if (!in_array($company->id, $viewed)) {
            $company->increment('reads');
            Session::push('reads', $company->id);
        }
        $jobs = $query->where(['company_id'=> $id ,'status' => 1])->latest()->paginate(10);
        if ($request->ajax()) {
            $view = view('components.web.job-data', compact('jobs'))->render();
            return response()->json(['html' => $view, 'jobs' => $jobs]);
        }

        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('name', 'ASC')->get();
        $jobTypes = JobType::with('job')->where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::with('city')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        return view('web.company-details', compact('company','jobs','categories', 'jobTypes', 'cities'));
    }


    public function blogs(Request $request)
    {
        $blogs = Blog::with('jobcategory', 'user')->where('status', 1)->orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(3);
        if ($request->ajax()) {
            $view = view('components.web.blogs-data', compact('blogs'))->render();
            return response()->json(['html' => $view, 'blogs' => $blogs]);
        }
        $blog = Blog::with('jobcategory', 'user')->where('status', 1)
            ->orderBy('reads', 'DESC')
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->first();

        return view('web.blogs', compact('blogs', 'blog'));
    }

    public function blogDetails($id, SEOManager $seoManager)
    {
        $blog = Blog::with('jobcategory')->where('status', 1)->where('id', $id)->first();

        if (empty($blog)) {
            return redirect(route('web.blogs'));
        }

        $datas = Blog::with('jobcategory')->where('status', 1)
            ->where('category_id', $blog->category_id)
            ->orderBy('id', 'DESC')->limit(6)->get();

        $blogData = json_decode($blog, true);

        $language = 'az';

        if (isset($blogData['title'][$language])) {
            $title = $blogData['title'][$language] . " | İşveren.az";
            SEOMeta::setTitle(htmlentities($title, ENT_QUOTES, 'UTF-8'));
        }

        if (isset($blogData['description'][$language])) {
            SEOMeta::setDescription($blogData['description'][$language]);
        }

        $viewed = Session::get('reads', []);
        if (!in_array($blog->id, $viewed)) {
            $blog->increment('reads');
            Session::push('reads', $blog->id);
        }
        return view('web.blog-details', compact('datas',  'blog', 'title'));
    }

    public function cv(Request $request)
    {
        $query = Cv::query();
        $query->where('status', 1);
        $query->orderBy('is_premium','DESC'); // ID-ə görə sıralama

        if ($request->filled('search')) {
            $searchTerm = strtolower(request('search'));
            $query->where('title','LIKE', ["%$searchTerm%"])
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name','LIKE', ["%$searchTerm%"])
                        ->orWhere('surname','LIKE', ["%$searchTerm%"]);
                });
        }

        if ($request->filled('main_category')) {
            $categoryId = $request->main_category;
            $query->where('category_id', $categoryId);
        }

        if ($request->filled('parent_category')) {
            $subCategoryId = $request->parent_category;
            $query->where('parent_category_id', $subCategoryId);
        }

        if ($request->filled('job_status')) {
            if ($request->job_status == 'is_premium') {
                $query->where('is_premium', 1);
            }elseif ($request->job_status == 'is_new') {
                $query->where('is_new', 1);
            }elseif ($request->job_status == 'is_top') {
                $query->where('is_top', 1);
            }elseif ($request->job_status == 'is_featured') {
                $query->where('is_featured', 1);
            }
        }
        if ($request->filled('short_by')) {
            switch ($request->short_by) {
                case 'is_firts':
                    $query->orderBy('id','DESC'); // ID-ə görə sıralama
                    break;

                case 'is_start_date':
                    $query->orderBy('created_at','DESC'); // start_date-ə görə sıralama
                    break;

                case 'is_name':
                    // JSON sahəsinin içindəki `az` açarına görə sıralama (MySQL 5.7+ üçün uyğundur)
                    $query->orderBy('title','ASC');
                    break;
            }
        }

        if ($request->filled('job_type')) {
            $query->whereIn('working_hour', (array) $request->job_type);
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        $cv = $query->with('user','city','workingHour')->latest()->paginate(10);
        if ($request->ajax()) {
            $view = view('components.web.cv-data', compact('cv'))->render();
            return response()->json(['html' => $view, 'cv' => $cv]);
        }
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('name', 'ASC')->get();
        $jobTypes = JobType::with('job')->where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::with('city')->where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        return view('web.cv', compact('cv','categories', 'jobTypes', 'cities'));
    }

    public function cvDetails($slug,$id, SEOManager $seoManager)
    {
        $data = Cv::with( 'user','country', 'city', 'category', 'parentCategory','workingHour')->where('status', 1)->where(['slug'=> $slug,'id'=>$id])->first();
        if (empty($data)) {
            return redirect(route('web.cv'));
        }

        $datas = Blog::with('jobcategory')->where('status', 1)
            ->where('category_id', $data->category_id)
            ->orderBy('id', 'DESC')->limit(6)->get();

        $cvData = json_decode($data->profession, true)['title']['az'] ?? '';


        if (isset($data['name']) || isset($cvData)) {
            $title = $data['name'] . " " . $data['surname'] . " " . $cvData . " | İşveren.az";
            SEOMeta::setTitle(htmlentities($title, ENT_QUOTES, 'UTF-8'));
        }

        if (isset($data['description'])) {
            SEOMeta::setDescription($data['description']);
        }

        $viewed = Session::get('reads', []);
        if (!in_array($data->id, $viewed)) {
            $data->increment('reads');
            Session::push('reads', $data->id);
        }
        return view('web.cv-details', compact('datas', 'data', 'title'));
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function contactform(Request $request)
    {

        try {
            $valdate = Validator::make($request->all(), [
                'full_name' => 'required|string',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'type' => 'required',
                'messages' => 'required|string|min:20|max:512',
                'captcha' => ['required'],
            ], [
                // full_name
                'full_name.required' => 'Ad boş olmamalıdır.',
                'full_name.string' => 'Ad yalnız mətn formatında olmalıdır.',

                // phone
                'phone.required' => 'Əlaqə nömrəsi boş olmamalıdır.',
                'phone.string' => 'Əlaqə nömrəsi yalnız mətn formatında olmalıdır.',
                'phone.max' => 'Əlaqə nömrəsi maksimum 15 simvol ola bilər.',

                // email
                'email.required' => 'E-poçt boş olmamalıdır.',
                'email.email' => 'Zəhmət olmasa düzgün e-poçt formatı daxil edin.',
                'email.max' => 'E-poçt maksimum 255 simvol ola bilər.',

                // type
                'type.required' => 'Tip boş olmamalıdır.',

                // messages
                'messages.required' => 'Mesaj boş olmamalıdır.',
                'messages.string' => 'Mesaj yalnız mətn formatında olmalıdır.',
                'messages.min' => 'Mesaj ən azı 20 simvol olmalıdır.',
                'messages.max' => 'Mesaj maksimum 512 simvol ola bilər.',
                'captcha.required' => 'Zəhmət olmasa simvolar qeyd edin',
            ]);

            if ($valdate->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $valdate->messages()
                ]);
            }

            $captcha = self::verifyCaptcha($request->companyCaptcha);
            if (!$captcha)
            {
                return response()->json([
                    'success' => false,
                    'errors' => 'Qeyd etdiyiniz simvolar doğru deyildir.'
                ]);
            }

            if (!in_array($request->type, ['users', 'company'])) {
                return response()->json([
                    'success' => false,
                    'errors' => Lang::get('web.err_type')
                ]);
            }

            $contact = new Contact();
            $contact->full_name = $request->full_name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->type = $request->type;
            $contact->messages = $request->messages;
            $contact->save();
            if (!empty($contact->id)) {
                return ['success' => true, 'message' => 'Müraciətiniz uğurla göndərildi'];
            }else {
                return ['success' => false, 'error' => 'Müraciətiniz uğurla göndərilmədi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    public function comingsoon()
    {
        return view('web.comingsoon');
    }

    //ajax sorgular
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $jobs = Job::where('title->az', 'like', '%' . $query . '%')->get();
        return response()->json($jobs);
    }
    public function subCategory($id)
    {
        $categories = Category::whereNotNull('parent_id')->where('parent_id', $id)->orderBy('name', 'ASC')->get();
        return response()->json($categories);
    }

    public function apiVacancy()
    {
        $jobs = Job::where('status', 1)->orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(20);
        return response()->json($jobs);
    }

    public function interact(Request $request)
    {
        $jobId = $request->job_id;
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $interactionType = $request->interaction;

            $follow = Follower::where('job_id', $jobId)->where('user_id', $userId)->first();

            if ($follow) {
                $follow->interaction_type = $interactionType;
                $follow->delete();
            } else {
                $follow = new Follower();
                $follow->job_id = $jobId;
                $follow->user_id = $userId;
                $follow->interaction_type = $interactionType;
                $follow->save();
            }
            return response()->json(['interaction' => $interactionType]);
        }
    }

    public function follower()
    {
        $jobs =  Job::whereHas('follower', function ($query) {
            $query->where('user_id', auth('web')->user()->id);
        })
            ->get();
        return view('web.follower', compact('jobs'));
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
}
