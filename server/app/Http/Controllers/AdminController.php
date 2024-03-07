<?php

namespace App\Http\Controllers;

use App\Models\Enums\MembershipRequestStatus;
use App\Models\Enums\UserRole;
use App\Models\MembershipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            fn (Request $request, $next) => ($request->user()->role === UserRole::ADMIN)
                ? $next($request)
                : abort(403)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function membershipRequestList()
    {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query =  MembershipRequest::where('status', MembershipRequestStatus::PENDING);
        return $query->with('membership.educationProgram.college')->get()->append(['attachment', 'attachment_url']);
    }

    public function membershipRequestApprove(MembershipRequest $membershipRequest, Request $request)
    {
        $payload = (object) Validator::make($request->all(), [
            'valid_until' => 'nullable|date|after:today',
        ])->validate();

        $membershipRequest->authorizedBy()->associate($request->user());
        $membershipRequest->status = $payload->valid_until ? MembershipRequestStatus::APPROVED : MembershipRequestStatus::REJECTED;
        $membershipRequest->authorized_at = now();
        $membershipRequest->valid_until = $payload->valid_until;

        $membershipRequest->save();
    }
}
