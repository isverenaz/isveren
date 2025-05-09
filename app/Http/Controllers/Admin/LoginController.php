<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function loginAccept(Request $request)
    {
        $loginState = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth('customer')->attempt($loginState)) {
            return redirect(route('admin.home'));
        } else {
            return redirect(route('login'));
        }
    }


    public function login()
    {
        return view('admin.auth.login');
    }

    public function logout()
    {
        \Session::flush();
        \Auth::logout();
        return redirect(route('login'));
    }
}
