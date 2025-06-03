<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Http\Controllers\DashboardController;


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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Auth::attempt($credentials);
            session()->put('user', Auth::user());
            return redirect()->route('dashboard');
        } else {
            $response['success'] = false;
            $response['message'] = 'Your username or password is wrong !';
            return $response;
        }
        $response['success'] = false;
        $response['message'] = 'Please contact administrator !';
        return $response;
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('dashboard');
    }

    public function forgotPassword()
    {
        return view('auth/forgot-password');
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        User::where('email', $request['email'])->update([
            'remember_token' => $token,
        ]);

        $params = [
            'url' => url('/auth/reset-password?token=' . $token . '&email=' . urlencode($request->email)),
            'email' => $request->email
        ];

        return [
            'success' => true,
            'title' => 'Success',
            'message' => 'Silahkan cek email anda untuk reset password.',
            'data' => $params
        ];
    }

    public function resetPassword(Request $request)
    {
        if ($request['token'] && $request['email']) {
            $checkEmail = User::where('email', $request['email'])->first();
            if ($checkEmail) {
                $updatedAt = Carbon::parse($checkEmail->updated_at);
                if ($updatedAt->diffInMinutes(now()) > 60 || $checkEmail->remember_token != $request['token']) {
                    return response()->json(['message' => 'Reset password telah kedaluwarsa'], 400);
                }

                return view('auth/reset-password', [
                    'token' => $request['token'],
                    'email' => $request['email']
                ]);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        User::where('email', $request['email'])->update([
            'password' => Hash::make($request['password']),
            'remember_token' => null,
        ]);

        return [
            'success' => true,
            'title' => 'Success',
            'message' => 'Password berhasil di ubah.',
        ];
    }
}
