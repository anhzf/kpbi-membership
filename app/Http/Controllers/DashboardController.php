<?php

namespace App\Http\Controllers;

use App\User;
use App\KPBI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('verified')->except(['members']);
    }

    public function myProfile()
    {
        return view('dashboard.profile', ['data' => KPBI::current_profile()]);
    }

    public function myAccount()
    {
        return view('dashboard.account', ['user' => Auth::user()]);
    }

    public function members(Request $request, KPBI $KPBI)
    {
        return view('dashboard.members', ['members' => $KPBI->orderBy('jenjang', 'asc')->get()]);
    }

    public function saveProfile(Request $request)
    {
        if (KPBI::save_info($request->all())) {
            session()->flash('flash', [['success', 'saved!']]);
        } else {
            session()->flash('flash', [['error', '❌ something wrong!']]);
        }
        return back();
    }

    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'passwordChange' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validate->fails()) {
            return redirect()->route('myAccountPage')
                            ->withErrors($validate);
        }
        
        $user_id = Auth::User()->id;                       
        $userInstance = User::find($user_id);
        $userInstance->password = Hash::make($request->input('passwordChange'));
        $userInstance->save();
        
        return back()->with('flash', [['success', __('dashboard.password.changed')]]);
    }
}
