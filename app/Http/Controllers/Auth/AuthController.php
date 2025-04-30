<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth/index');
    }

    public function authentication(Request $request)
    {
        $response = [];
        $credentials = $request->validate([
            'email' => 'required|email',
            // 'email' => ['required','email'],
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            Auth::attempt($credentials);
            session()->put('user', Auth::user());
            return redirect()->route('backoffice');
        }else{
            $response['success']=false;
            $response['message']='Your username or password is wrong !';
            return $response;
        }
        $response['success']=false;
        $response['message']='Please contact administrator !';
        return $response;
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('backoffice');
    }
}
