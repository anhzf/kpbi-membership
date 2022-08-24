<?php

namespace App\Http\Controllers;

use App\Models\MembershipRequest;
use App\Http\Requests\StoreMembershipRequestRequest;
use App\Http\Requests\UpdateMembershipRequestRequest;

class MembershipRequestController extends Controller
{
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
     * @param  \App\Http\Requests\StoreMembershipRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembershipRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MembershipRequest  $membershipRequest
     * @return \Illuminate\Http\Response
     */
    public function show(MembershipRequest $membershipRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMembershipRequestRequest  $request
     * @param  \App\Models\MembershipRequest  $membershipRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembershipRequestRequest $request, MembershipRequest $membershipRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MembershipRequest  $membershipRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(MembershipRequest $membershipRequest)
    {
        //
    }
}
