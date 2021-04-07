<?php

namespace App\Http\Controllers\Auth\API;

use App\User;
use App\KPBI;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $data = $request->all();

    KPBI::requiredDataValidator($data, KPBI::FIRST_ATTEMPT)->validate();
    $data = $data + KPBI::generateLoginCredentials($request->all());
    $data['password_confirmation'] = $data['password'];

    $this->validator($data)->validate();
    // Trigger an event
    // event(new Registered($user = $this->create($data)));

    $user = $this->create($data);
    // Register as KPBI Member
    $this->KPBIRegister($request, $user);

    $user->sendEmailVerificationNotification();

    return response()->json([
      'success' => true,
      'message' => 'Selamat! Akun anda telah terdaftar! Silahkan cek email ' . $user->getEmailForVerification() . ' untuk verifikasi!'
    ]);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
      'name' => [
        'unique:users' => ':input sudah didaftarkan untuk akun prodi yang lain',
      ],
    ]);
  }

  /**
   * Create a new user instance and KPBI profile after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  /**
   * The user has been registered.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \App\User        $user
   */
  protected function KPBIRegister(Request $request, $user): void
  {
    $data = $request->except(['name', 'email', 'password']) + ['user_id' => $user->id];

    KPBI::save_info($data, KPBI::FIRST_ATTEMPT);
  }
}
