<?php

namespace App\Http\Controllers\KPBI;

use App\Http\Controllers\Controller;
use App\User;
use App\KPBI;
use Illuminate\Http\Request;


class ProfileAPIController extends Controller
{
    public function get(Request $request)
    {
        return $request->user()->kpbi_profile;
    }

    public function getAll()
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

    public function update(Request $request)
    {
        if (KPBI::save_info($request->all() + ['user_id' => $request->user()->id]))
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
}
