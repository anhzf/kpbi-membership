<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKpbiProfileRequest;
use App\Http\Requests\UpdateKpbiProfileRequest;
use App\Models\Kaprodi;
use App\Models\KpbiProfile;
use App\Models\PerguruanTinggi;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class KpbiProfileController extends APIController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->send(KpbiProfile::all());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreKpbiProfileRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreKpbiProfileRequest $request)
  {
    $data = $request->safe();

    $kpbiProfile = (new KpbiProfile())->fill([
      'jenjang' => $data->jenjang,
      'nama_prodi' => $data->nama_prodi,
      'nama_perguruan_tinggi' => $data->nama_perguruan_tinggi_lengkap,
      'email_kantor_prodi' => $data->email_kantor_prodi,
    ]);

    $perguruanTinggi = (new PerguruanTinggi())->fill([
      'nama_singkat' => $data->nama_perguruan_tinggi_singkat,
      'nama_lengkap' => $data->nama_perguruan_tinggi_lengkap,
    ]);

    $kaprodi = (new Kaprodi())->fill([
      'email' => $data->email_kaprodi,
    ]);

    $username = KpbiProfile::constructUsername($kpbiProfile, $perguruanTinggi);
    /** @var User */
    $user = User::create([
      'name' => $username,
      'username' => $username,
      'email' => $data->email_kaprodi,
      'password' => Hash::make($username),
    ]);

    $user->kpbiProfile()->save($kpbiProfile);
    $kpbiProfile->perguruanTinggi()->save($perguruanTinggi);
    $kpbiProfile->kaprodi()->save($kaprodi);

    event(new Registered($user));

    return $this->send([
      'user' => $user,
      'profile' => $kpbiProfile->load(['perguruanTinggi', 'kaprodi']),
      'token' => $user->createToken('authToken')->plainTextToken,
    ], 'Berhasil membuat akun KPBI!');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\KpbiProfile  $kpbiProfile
   * @return \Illuminate\Http\Response
   */
  public function show(KpbiProfile $kpbiProfile)
  {
    return $this->send($kpbiProfile->details());
  }

  /**
   * Display the specified resource current user
   *
   * @return \Illuminate\Http\Response
   */
  public function showIam(Request $request)
  {
    /** @var KpbiProfile */
    $kpbiProfile = $request->user()->kpbiProfile;

    return $this->send($kpbiProfile->details());
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateKpbiProfileRequest  $request
   * @param  \App\Models\KpbiProfile  $kpbiProfile
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateKpbiProfileRequest $request, KpbiProfile $kpbiProfile)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\KpbiProfile  $kpbiProfile
   * @return \Illuminate\Http\Response
   */
  public function destroy(KpbiProfile $kpbiProfile)
  {
    //
  }
}
