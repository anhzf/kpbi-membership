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
            'img' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ])->safe();

        $ATTRS = ['name', 'email'];

        if (isset($payload->img)) {
            $user->addMedia($payload->img)
                ->toMediaCollection('avatar');
        }

        foreach ($ATTRS as $attr) {
            if (isset($payload->$attr)) {
                $user->$attr = $payload->$attr;
            }
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
