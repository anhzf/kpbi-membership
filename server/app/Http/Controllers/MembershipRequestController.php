<?php

namespace App\Http\Controllers;

use App\Models\MembershipRequest;
use App\Http\Requests\StoreMembershipRequestRequest;
use App\Http\Requests\UpdateMembershipRequestRequest;
use App\Models\EducationProgramHead;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;

class MembershipRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var EducationProgramHead */
        $headProgram = request()->user()->headOf();
        return $headProgram->program->membership
            ->load(['requests' => function (HasMany $query) {
                $query->orderBy('requested_date', 'desc');
            }])
            ->requests
            ->append(['attachment', 'attachment_url']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMembershipRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembershipRequestRequest $request)
    {
        /** @var UploadedFile */
        $file = $request->safe()->file;
        /** @var User */
        $user = $request->user();
        /** @var EducationProgramHead */
        $headProgram = $user->headProgramOf->first();

        $membershipRequest = $headProgram->program->membership->requests()->create([
            'requested_date' => now(),
            'user_id' => $user->id,
            'status' => MembershipRequest::STATUS_DEFAULT,
        ]);

        $membershipRequest->addMedia($file)->toMediaCollection('membership_requests');
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
