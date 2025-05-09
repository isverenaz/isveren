<?php

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Notifications\Mail;
use App\Repositories\RoleRepositoryImpl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use \Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryImpl $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function redirectToUserGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleUserGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $this->_registerOrLoginUser($user);
            return redirect()->route('web.home');
        } catch (Exception $e) {
            return redirect()->route('web.login');
        }
    }
    public function redirectToCompanyGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCompanyGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $this->_registerOrLoginCompany($user);
            return redirect()->route('web.home');
        } catch (Exception $e) {
            return redirect()->route('web.login');
        }
    }


    protected function _registerOrLoginUser($data)
    {
        $name_surname = $data->name;
        $name_surname = explode(" ", $name_surname);
        $name = $name_surname[0];
        $surname = $name_surname[1] ??$name_surname[0];
        $user = User::where(['email' => $data->email, 'status' => 1])->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'surname' => $surname,
                'email' => $data->email,
                'phone' => NULL,
                'provider_id' => $data->id,
                'status' => 1,
                'password' => Hash::make($data->id)
            ]);


            $role = 'users';
            if ($role) {
                $roles = $this->roleRepository->findBySlug($role);
                $user->roles()->attach($roles);
            }
            $message = "Hesabınıza daxil oldunuz. Növbəti zamanlar üçün sizin giriş məlumatlarınız: ";
            $mail_data = [
                'title' => 'Qeydiyyat',
                'subject' => $message,
                'email' => $data->email,
                'password' => $data->id,
                'url' => 'https://isveren.az'
            ];
            Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
        }

        auth('web')->login($user);
    }
    protected function _registerOrLoginCompany($data)
    {
        $name_surname = $data->name;
        $name_surname = explode(" ", $name_surname);
        $name = $name_surname[0];
        $surname = $name_surname[1] ??$name_surname[0];
        $user = User::where(['email' => $data->email, 'status' => 1])->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'surname' => $surname,
                'email' => $data->email,
                'phone' => NULL,
                'provider_id' => $data->id,
                'status' => 1,
                'password' => Hash::make($data->id)
            ]);


            $role = 'company';
            if ($role) {
                $roles = $this->roleRepository->findBySlug($role);
                $user->roles()->attach($roles);
            }
            $message = "Hesabınıza daxil oldunuz. Növbəti zamanlar üçün sizin giriş məlumatlarınız: ";
            $mail_data = [
                'title' => 'Qeydiyyat',
                'subject' => $message,
                'email' => $data->email,
                'password' => $data->id,
                'url' => 'https://isveren.az'
            ];
            Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
        }

        auth('web')->login($user);
    }

    /*public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();

            $this->_registerOrLoginUser($user);
            return redirect()->route('web.home');
        } catch (Exception $e) {
            return redirect()->route('web.login');
        }
    }*/
}
