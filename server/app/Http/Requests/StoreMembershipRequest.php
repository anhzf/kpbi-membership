<?php

namespace App\Http\Requests;

use App\Enums\AcademicDegree;
use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $academicDegrees = join(',', AcademicDegree::toArray());

        return [
            'degree' => "required|string|in:{$academicDegrees}",
            'college_name' => 'required|string',
            'college_short_name' => 'required|string',
            'program_name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
