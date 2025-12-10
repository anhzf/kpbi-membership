<?php

namespace App\Http\Controllers\V2;

use App\Http\Api;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function getMembershipFee()
    {
        $setting = Setting::find('membership_fee');
        return Api::data((int) $setting->value->number_value);
    }

    public function setMembershipFee(Request $request)
    {
        $body = $request->validate([
            'amount' => 'required|integer|min:0',
        ]);

        /** @var Setting */
        $setting = Setting::find('membership_fee');
        $setting->value = data_set($setting->value, 'number_value', $body['amount']);

        $setting->save();

        return response()->noContent();
    }

    public function getInvoiceDocContactPerson()
    {
        $setting = Setting::find('doc_invoice_contact_person_user');
        $user = User::find($setting->value, ['id', 'name', 'email', 'phone_number', 'employee_id']);

        return Api::data($user);
    }

    public function setInvoiceDocContactPerson(Request $request)
    {
        $body = $request->validate([
            'person_id' => 'required|exists:users,id',
        ]);

        $setting = Setting::find('doc_invoice_contact_person_user');
        $setting->value = $body['person_id'];
        $setting->save();

        return response()->noContent();
    }

    public function getInvoiceDocTreasurer()
    {
        $setting = Setting::find('doc_invoice_treasurer_user');
        $user = User::find($setting->value, ['id', 'name', 'email', 'phone_number', 'employee_id']);

        return Api::data($user);
    }

    public function setInvoiceDocTreasurer(Request $request)
    {
        $body = $request->validate([
            'person_id' => 'required|exists:users,id',
        ]);

        $setting = Setting::find('doc_invoice_treasurer_user');
        $setting->value = $body['person_id'];
        $setting->save();

        return response()->noContent();
    }
}
