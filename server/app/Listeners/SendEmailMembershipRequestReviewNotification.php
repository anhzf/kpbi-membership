<?php

namespace App\Listeners;

use App\Events\MembershipRequestReviewed;
use App\Models\Enums\MembershipRequestStatus;
use App\Notifications\MembershipRequestReviewedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEmailMembershipRequestReviewNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(MembershipRequestReviewed $event)
    {
        Log::debug('MembershipRequestReviewed event fired');
        if ($event->membershipRequest->status !== MembershipRequestStatus::PENDING) {
            $event->membershipRequest
                ->notify(new MembershipRequestReviewedNotification);
        }
    }
}
