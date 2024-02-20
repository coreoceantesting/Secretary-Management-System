<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'name' => 'required',
            'head_person_name' => 'required',
            'head_person_designation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Please enter name',
            'head_person_name' => 'Please enter head person name',
            'head_person_designation' => 'Please enter head person designation',
        ];
    }
}