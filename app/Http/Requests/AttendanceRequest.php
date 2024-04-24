<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'department_id.*' => 'required',
            'name.*' => 'required',
            'department_in_time.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'department_id.*.required' => 'Please select department',
            'name.*.required' => 'Please enter name',
            'department_in_time.*.required' => 'Please select in time'
        ];
    }
}
