<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        return view('admin.login');
    }



    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if(Auth::attempt($credentials))
        {

            $request->session()->regenerate();


            return redirect()
                ->route('admin.dashboard');

        }


        return back()->with(
            'error',
            'Email atau password salah.'
        );

    }



    public function showForgotForm()
    {
        return view('admin.forgot-password');
    }



    public function sendResetLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);


        $status = Password::sendResetLink(
            $request->only('email')
        );


        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password sudah dikirim ke email kamu.')
            : back()->withErrors(['email' => __($status)]);

    }



    public function showResetForm(Request $request, $token)
    {

        return view('admin.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);

    }



    public function resetPassword(Request $request)
    {

        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

            }
        );


        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil diubah, silakan login.')
            : back()->withErrors(['email' => __($status)]);

    }



    public function logout(Request $request)
    {

        Auth::logout();


        $request->session()->invalidate();


        $request->session()->regenerateToken();


        return redirect()
            ->route('login');

    }

}
