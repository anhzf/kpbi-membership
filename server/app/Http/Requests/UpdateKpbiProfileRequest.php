<?php

namespace App\Http\Requests;

class UpdateKpbiProfileRequest extends StoreKpbiProfileRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    /** @var \App\Models\User */
    $user = $this->user();
    return $this->request->user_id === $user->id;
  }
}
