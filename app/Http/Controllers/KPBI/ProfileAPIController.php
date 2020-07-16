<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class ProfileAPIController extends Controller
{
    public function getProfile(/* $id,  */Request $request)
    {
        if ($user = User::find($request->id)) {
            return $user->kpbi_profile;
        }

        return response(['error' => 'didn\'t find any match user'], 404);
    }

    public function getAllProfiles()
    {
        $users = User::all();

        $members = $users->map(function ($user) {
            return $user->kpbi_profile;
        });

        return $members->all();
    }
}
