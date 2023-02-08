<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string',
            'credits' => 'required|integer',
            'description' => 'nullable|string',
            'info.cpmk' => 'required|string',
            'lecturer' => 'required|string',
            'semester' => 'required|string',
            'education_program_id' => 'required|exists:App\Models\EducationProgram,id',
        ];
    }
}