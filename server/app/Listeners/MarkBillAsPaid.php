<?php

namespace App\Listeners;

use App\Events\MembershipRequestReviewed;
use App\Models\Enums\MembershipRequestStatus;
use App\Models\Membership;
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

                $bill->items = $bill->items->map(function ($item, $key) use ($event) {
                    if ($key === Membership::BILL_INVOICE_ITEM_NAME) {
                        $product = (object) Membership::BILL_INVOICE_ITEMS[Membership::BILL_INVOICE_ITEM_NAME];

                        $item['ref'] = $event->membershipRequest->id;
                        $item['price'] = $product->price;
                        $item['qty'] = $event->membershipRequest->amount / $product->price;
                    }
                    return $item;
                });

                $bill->save();

                dump($bill);
            }
        }
    }
}
