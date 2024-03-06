<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RescheduleMeetingRequest extends FormRequest
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
            'meeting_id' => 'required',
            'schedule_meeting_id' => 'required',
            'department_id.*' => 'required',
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'meeting_id.required' => 'Please select meeting',
            'date.required' => 'Please select date',
            'time.required' => 'Please select time',
            'time.place' => 'Please enter place',
        ];
    }
}
