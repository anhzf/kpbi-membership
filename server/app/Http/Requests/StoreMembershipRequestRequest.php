<?php

namespace App\Http\Requests;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMembershipRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User */
        $user = $this->user();
        return $user->headProgramOf->first()->exists;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $membershipFee = Membership::BILL_INVOICE_ITEMS[Membership::BILL_INVOICE_ITEM_NAME]['price'];
        return [
            'file' => [Rule::file()->types(['application/pdf', 'image/*'])->max(2048)],
            'transfer_at' => ['required', 'date'],
            'amount' => ['numeric', 'nullable', "multiple_of:{$membershipFee}"],
        ];
    }
}
