<?php

namespace App\Http\Controllers;

use App\Helper\FlashMsg;
use App\User;
use App\KPBI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }

    public function myProfile()
    {
        $this->flash_info();
        return view('dashboard.profile', ['data' => KPBI::current_profile()]);
    }

    public function myAccount()
    {
        $this->flash_info();
        return view('dashboard.account', ['user' => Auth::user()]);
    }
    
    public function saveProfile(Request $request)
    {
        if (KPBI::save_info($request->all() + ['user_id' => Auth::user()->id])) {
            FlashMsg::add('success', 'saved!');
        } else {
            FlashMsg::add('error', '❌ something wrong!');
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

    public function flash_info()
    {
        // Check if Required data is not fulfilled then give flash message
        if (KPBI::requiredDataValidator(Auth::user()->kpbi_profile->attributesToArray())->fails()) {
            FlashMsg::add('info', __('Data profil KPBI anda belum lengkap, Silahkan lengkapi data profil di Dashboard kemudian Bagian Profil'));
        }        
    }
}
