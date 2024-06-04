<?php

namespace App\Listeners;

use App\Events\MembershipRequestReviewed;
use App\Models\Enums\MembershipRequestStatus;
use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkBillAsPaid
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
        if ($event->membershipRequest->status === MembershipRequestStatus::APPROVED) {
            if ($bill = collect($event->membershipRequest->membership->bill())->last()) {
                $bill->paid_at = now();
                $bill->save();
            }
        }
    }
}
