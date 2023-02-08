<?php

namespace App\Http\Requests;

class UpdateCourseRequest extends StoreCourseRequest
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
        return [
            'name' => 'string',
            'code' => 'string',
            'credits' => 'integer',
            'description' => 'nullable|string',
            'info.cpmk' => 'string',
            'lecturer' => 'string',
            'semester' => 'string',
        ];
    }
}
