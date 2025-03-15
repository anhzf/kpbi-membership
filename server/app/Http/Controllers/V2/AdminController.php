<?php

namespace App\Http\Controllers\V2;

use App\Http\Api;
use App\Http\Controllers\AdminController as V1;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\MembershipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends V1
{
    public function getMembershipRequestStates()
    {
        return Api::data(
            MembershipRequest::select('membership_requests.id')
                ->leftJoin('invoices', 'membership_requests.id', '=', DB::raw('JSON_EXTRACT(invoices.items, "$.membership.ref")'))
                ->addSelect('invoices.id as invoice_id')
                ->get()
        );
    }

    public function attachMembershipRequestToInvoice(Invoice $invoice, Request $request)
    {
        $ITEM_NAME = Membership::BILL_INVOICE_ITEM_NAME;

        $payload = Validator::make($request->all(), [
            'id' => 'required|exists:membership_requests,id',
        ])->safe();

        if (isset($invoice->items->get($ITEM_NAME)['ref'])) {
            abort(400, "Invoice already has a membership");
        }

        $membershipRequest = MembershipRequest::findOrFail($payload->id);

        if ($membershipRequest->invoices->isNotEmpty()) {
            abort(400, "Membership request already has an invoice");
        }

        $invoice->update([
            "items->{$ITEM_NAME}->ref" => $payload->id
        ]);
    }
}
