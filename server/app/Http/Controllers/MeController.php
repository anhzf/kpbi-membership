<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        /** @var User */
        $user = $request->user();
        $payload = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'phone_number' => 'sometimes|string',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ])->safe();

        $ATTRS = ['name', 'email', 'phone_number'];

        if (isset($payload->img)) {
            $user->addMedia($payload->img)
                ->toMediaCollection('avatar');
        }

        foreach ($ATTRS as $attr) {
            if (isset($payload->$attr)) {
                $user->$attr = $payload->$attr;
            }
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        } else if ($user->isClean()) {
            return response(status: 204);
        }

        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
