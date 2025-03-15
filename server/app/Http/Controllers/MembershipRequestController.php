<?php

namespace App\Http\Controllers;

use App\Http\Api;
use App\Models\MembershipRequest;
use App\Http\Requests\StoreMembershipRequestRequest;
use App\Http\Requests\UpdateMembershipRequestRequest;
use App\Models\EducationProgramHead;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;

class MembershipRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('show');
    }

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
                $query->orderBy('created_at', 'desc');
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
        $payload = $request->safe();

        /** @var UploadedFile */
        $file = $payload->file;
        /** @var User */
        $user = $request->user();
        $headProgram = $user->headOf();

        $membershipRequest = $headProgram->program->membership->requests()->create([
            'requested_date' => now(),
            'transfer_at' => $payload->transfer_at,
            'user_id' => $user->id,
            'status' => MembershipRequest::STATUS_DEFAULT,
            'amount' => $payload->amount,
        ]);

        $membershipRequest->addMedia($file)->toMediaCollection('membership_requests');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MembershipRequest  $membershipRequest
     * @return \Illuminate\Http\Response
     */
    public function show(MembershipRequest $membership)
    {
        return $membership;
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

    public function showInvoice(MembershipRequest $membershipRequest)
    {
        $itemName = Membership::BILL_INVOICE_ITEM_NAME;;
        return Api::data(
            Invoice::where("items->{$itemName}->ref", $membershipRequest->id)
                ->firstOrFail()
        );
    }
}
