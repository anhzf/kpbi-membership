<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\User;
use App\KPBI;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ProfileAPIController extends Controller
{
  /**
   * Media Validator
   *
   * @var array
   */
  const mediaValidator = ['required', 'image', 'max:' . Media::maxFileSize];


  public function get(Request $request)
  {
    $res = $request->user()->kpbi_profile->toArray();

    if (KPBI::requiredDataValidator($res)->fails()) {
      $res['warn'] = __('Profil KPBI anda belum lengkap. Silahkan lengkapi profil keanggotaan KPBI...');
    }

    if (KPBI::requiredDataValidator($res)->fails()) {
      $res['warn'] = __('Profil KPBI anda belum lengkap. Silahkan lengkapi profil keanggotaan KPBI...');
    }

    return response()->json($res);
  }

  public function getAll()
  {
    $users = User::all();

    $members = $users->map(function ($user) {
      return $user->kpbi_profile;
    });

    $fullfilledData = $members->filter(function ($member) {
      if ($member instanceof KPBI) {
        return !(KPBI::requiredDataValidator($member->attributesToArray())
          ->fails());
      }
    });

    $members = array_values($fullfilledData->toArray());

    foreach ($members as $index => $member) {
      $members[$index]['no'] = $index + 1;
    }

    return response()->json($members);
  }

  public function update(Request $request)
  {
    // Use FIRST_ATTEMPT to prevent unsaved changes when not fulfilled
    if (KPBI::save_info($request->all() + ['user_id' => $request->user()->id], KPBI::FIRST_ATTEMPT))
      $res = [
        'success' => true,
        'message' => 'Profile updated!'
      ];
    else
      $res = [
        'success' => false,
        'message' => '❌ something wrong!',
      ];

    return response()->json($res);
  }

  /**
   * Upload PT image
   *
   * @return \App\KPBI
   */
  public function uploadPTimg(Request $request)
  {
    $request->validate(['pt_img' => ProfileAPIController::mediaValidator]);
    $img = $request->file('pt_img');
    $img = $this->uploadMedia($img);

    $profile = $request->user()->kpbi_profile;
    $profile->update([
      'pt_icon' => $img->getKey()
    ]);
    $profile->save();

    return $profile;
  }

  /**
   * Upload PT image
   *
   * @return \App\KPBI
   */
  public function uploadKaprodiimg(Request $request)
  {
    $request->validate(['kaprodi_img' => ProfileAPIController::mediaValidator]);
    $img = $request->file('kaprodi_img');
    $img = $this->uploadMedia($img);

    $profile = $request->user()->kpbi_profile;
    $profile->update([
      'kaprodi_img' => $img->getKey()
    ]);
    $profile->save();

    return $profile;
  }

  /**
   * Upload media for KPBI Profile
   *
   * @return \App\Media
   */
  protected function uploadMedia(UploadedFile $img)
  {
    return Media::store(Auth::user(), $img, ['prefix' => 'img']);
  }
}
