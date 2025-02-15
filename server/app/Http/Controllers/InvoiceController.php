<?php

namespace App\Http\Controllers;

use App\Http\Api;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Setting;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($membershipId = $request->query('membership')) {
            /** @var Membership */
            $member = Membership::findOrFail($membershipId);

            return Api::data(
                QueryBuilder::for($member->invoices())
                    ->allowedFilters([
                        AllowedFilter::callback('active', function (Builder $query, $value) {
                            switch ($value) {
                                case true:
                                    $query->where('paid_at', null);
                                    break;

                                case false:
                                    $query->where('paid_at', '!=', null);
                                    break;

                                default:
                                    break;
                            }
                        }),
                    ])
                    ->defaultSort('created_at')
                    ->allowedSorts(['created_at', 'updated_at'])
                    ->get()
            );
        }

        abort(400, '`membership` is required');
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
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return $invoice;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function showDocumentPayload(Invoice $invoice)
    {
        $invoice_number = join('/', [
            Str::of($invoice->id)->padLeft(4, '0'),
            Utils::intToRomanNumeral($invoice->created_at->month),
            'KPBI',
            $invoice->created_at->year,
        ]);
        $receipt_to = $invoice->receipt_to_details;
        $_item = (object) $invoice->items[Membership::BILL_INVOICE_ITEM_NAME];
        $item = [
            'name' => Membership::BILL_INVOICE_ITEM_NAME,
            'price' => $_item->price,
            'qty' => $_item->qty,
            'desc' => $_item->desc,
        ];
        $due_at = $invoice->due_at;
        $paid_at = $invoice->paid_at;
        $created_at = $invoice->created_at;
        $contact_person = User::find(Setting::find('doc_invoice_contact_person_user')->value, ['name', 'email', 'phone_number', 'employee_id']);
        $treasurer = User::find(Setting::find('doc_invoice_treasurer_user')->value, ['name', 'email', 'phone_number', 'employee_id']);

        return Api::data(compact(
            'invoice_number',
            'receipt_to',
            'item',
            'due_at',
            'paid_at',
            'created_at',
            'contact_person',
            'treasurer',
        ));
    }
}
