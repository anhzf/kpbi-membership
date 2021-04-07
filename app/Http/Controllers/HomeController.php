<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
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
    $members = $KPBI->orderBy('jenjang', 'asc')->get();

    $fulfilledData_members = $members->filter(function($member) {
      return !(KPBI::requiredDataValidator($member->attributesToArray())
        ->fails());
    });

    $fulfilledData_members_paginate = HomeController::members_paginate($fulfilledData_members, 50);

    return view('member.index', ['members' => $fulfilledData_members_paginate]);
  }

  public static function members_paginate($members, $perPage = 15, $page = null)
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $total = $members->count();
    $options = [
      'path' => Paginator::resolveCurrentPath(),
    ];

    return new LengthAwarePaginator($members->forPage($page, $perPage), $total, $perPage, $page, $options);
  }

}
