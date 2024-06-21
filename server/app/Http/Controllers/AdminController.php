<?php

namespace App\Http\Controllers;

use App\Events\MembershipRequestReviewed;
use App\Models\Enums\MembershipRequestStatus;
use App\Models\Enums\UserRole;
use App\Models\MembershipRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            fn (Request $request, $next) => (
                array_search($request->user()->role, UserRole::toArray()) !== false
            )
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
        $query =  MembershipRequest::where('status', MembershipRequestStatus::PENDING)
            ->orderBy('requested_date', 'desc');
        return $query->with('membership.educationProgram.college')->get()->append(['attachment', 'attachment_url']);
    }

    public function membershipRequestApprove(MembershipRequest $membershipRequest, Request $request)
    {
        $payload = Validator::make($request->all(), [
            'valid_until' => 'nullable|date|after:today',
            'registration_id' => 'nullable|string',
        ])->safe();

        DB::transaction(function () use ($membershipRequest, $request, $payload) {
            $membershipRequest->authorizedBy()->associate($request->user());
            $membershipRequest->status = $payload->valid_until ? MembershipRequestStatus::APPROVED : MembershipRequestStatus::REJECTED;
            $membershipRequest->authorized_at = now();
            $membershipRequest->valid_until = $payload->valid_until;

            // TODO: Uses event instead of direct update
            $membershipRequest->membership->period_end = $payload->valid_until;
            $membershipRequest->membership->registration_id = $payload->registration_id;

            $membershipRequest->push();
        });

        event(new MembershipRequestReviewed($membershipRequest));
    }

    public function listUsers()
    {
        return User::all();
    }

    public function setUserRole(User $user, Request $request)
    {
        if ($user->role !== UserRole::ADMIN) {
            abort(403, 'Cannot change role of admin');
        }

        $payload = Validator::make($request->all(), [
            'role' => ['sometimes', 'nullable', new Enum(UserRole::class)],
        ])->safe();

        $user->role = $payload->role ?? null;
        $user->save();
    }
}
