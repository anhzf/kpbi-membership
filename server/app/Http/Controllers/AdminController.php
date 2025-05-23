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
            fn(Request $request, $next) => (
                array_search($request->user()->role, UserRole::cases()) !== false
            )
                ? $next($request)
                : abort(403)
        );
    }

    public function membershipRequestList(Request $request)
    {
        $status = MembershipRequestStatus::from($request->input('status', MembershipRequestStatus::PENDING));
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query =  MembershipRequest::where('status', $status)
            ->orderBy('requested_date', 'desc');
        return $query->with('membership.educationProgram.college')->get()->append(['attachment', 'attachment_url']);
    }

    public function membershipRequestApprove(MembershipRequest $membershipRequest, Request $request)
    {
        $payload = Validator::make($request->all(), [
            'valid_start' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_start',
            'registration_id' => 'nullable|string',
            'amount' => 'nullable|numeric',
        ])->safe();

        DB::transaction(function () use ($membershipRequest, $request, $payload) {
            $membershipRequest->authorizedBy()->associate($request->user());
            $membershipRequest->status = $payload->valid_until
                ? MembershipRequestStatus::APPROVED : MembershipRequestStatus::REJECTED;
            $membershipRequest->authorized_at = now();
            $membershipRequest->valid_start = $payload->valid_start;
            $membershipRequest->valid_until = $payload->valid_until;
            $membershipRequest->amount = $payload->amount ?? $membershipRequest->amount;

            // TODO: Uses event instead of direct update
            if (isset($payload->valid_until) || isset($payload->registration_id)) {
                $membershipRequest->membership->period_end = $payload->valid_until;
                $membershipRequest->membership->registration_id = $payload->registration_id;
            }

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
        if ($request->user()->role !== UserRole::ADMIN) {
            abort(403, 'Cannot change role of admin');
        }

        $payload = Validator::make($request->all(), [
            'role' => ['sometimes', 'nullable', new Enum(UserRole::class)],
        ])->safe();

        $user->role = $payload->role ?? null;
        $user->save();
    }
}
