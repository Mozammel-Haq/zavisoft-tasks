<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm(){

        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function login(Request $request){
        $credentials =  $request->validate([
            'email' => ['required','email'],
            'password'=>['required','string']
        ]);

        if(Auth::attempt($credentials,$request->boolean('remember'))){
            $request->session()->regenerate();

            // Generating SSO token
            $token = Auth::user()->createToken('zavi-sso-token')->accessToken;
            session(['zavi-sso-token'=>$token]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => "The Credentials You Entered do not Match Our Records."
        ])->onlyInput('email');

    }

    public function logout(Request $request){

        if(Auth::check()){
            Auth::user()->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('login');
    }

}
