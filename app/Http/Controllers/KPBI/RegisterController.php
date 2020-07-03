<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\KPBI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function ShowRegisterForm()
    {
        if (Auth::check()) return redirect()->route('profile');
        
        // $form = [
        //     'Jenjang' => ['S1', 'S2', 'S3'],
        //     'Nama Prodi' => '',
        //     'Perguruan Tinggi' => [
        //         'Lengkap' => '',
        //         'Singkat' => '', 
        //     ],
        //     'Email Prodi' => [
        //         'type' => 'email'
        //     ],
        //     'Email Kaprodi' => [
        //         'type' => 'email'
        //     ],
        // ];

        return view('home.register'/* , ['form' => $form] */);
    }

    public function register(Request $request)
    {   
        $data = $request->all();

        KPBI::requiredDataValidator($data, KPBI::FIRST_ATTEMPT)->validate();

        $data = $data + KPBI::generateLoginCredentials($request->all());
        $data['password_confirmation'] = $data['password'];

        // Use Auth\RegisterController to Handle next action
        return app('App\Http\Controllers\Auth\RegisterController')->register((new Request($data)));
    }
}
