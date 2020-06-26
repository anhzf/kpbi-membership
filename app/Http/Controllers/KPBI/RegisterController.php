<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\KPBI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function ShowRegisterForm()
    {
        if (Auth::check()) return redirect()->route('myProfile');
        
        $form = [
            'Jenjang' => ['S1', 'S2', 'S3'],
            'Nama Prodi' => '',
            'Perguruan Tinggi' => [
                'Lengkap' => '',
                'Singkat' => '', 
            ],
            'Email Prodi' => [
                'type' => 'email'
            ],
            'Email Kaprodi' => [
                'type' => 'email'
            ],
        ];

        return view('home.register'/* , ['form' => $form] */);
    }

    public function register(Request $request)
    {
        $request->validate([
            'jenjang' => ['required'],
            'nama_prodi' => ['required'],
            'pt.lengkap' => ['required'],
            'pt.singkat' => ['required'],
            'email_prodi' => ['required', 'email'],
            'email_kaprodi' => ['required', 'email'],
        ]);

        $generatedPassword = strtolower("{$request->jenjang}PBIO{$request->pt['singkat']}");
        $generatedUser = strtoupper("{$request->jenjang} PBIO {$request->pt['singkat']}");

        $request->flash();
        session()->flash('temp', $generatedPassword);

        $userProfile = [
            'name' => $generatedUser,
            'email' => $request->email_kaprodi,
            'password' => $generatedPassword,
            'password_confirmation' => $generatedPassword,
        ];

        return app('App\Http\Controllers\Auth\RegisterController')->register((new Request($userProfile)));
    }
}
