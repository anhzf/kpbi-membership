<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KPBI;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified')->except(['members']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function members(Request $request, KPBI $KPBI)
    {
        $members = $KPBI->orderBy('jenjang', 'asc')->paginate(15);

        return view('members', ['members' => $members]);
    }

}
