<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\User;
use App\KPBI;
use Illuminate\Http\Request;


class ProfileAPIController extends Controller
{
    public function getProfile(Request $request)
    {
        if ($user = User::find($request->id)) {
            return $user->kpbi_profile;
        }

        return response()->json(['error' => 'didn\'t find any match user'], 404);
    }

    public function getAllProfiles()
    {
        $users = User::all();

        $members = $users->map(function ($user) {
            return $user->kpbi_profile;
        });

        $fullfilledData = $members->filter(function($member) {
            return !(KPBI::requiredDataValidator($member->attributesToArray())
                ->fails());
        });

        $members = array_values($fullfilledData->toArray());

        foreach ($members as $index => $member) {
            $members[$index]['no'] = $index+1;
        }
        
        return response()->json($members);
    }
}
