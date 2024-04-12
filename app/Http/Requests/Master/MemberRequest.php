<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'ward_id' => 'required',
            'name' => 'required',
            'contact_number' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'party_id' => 'required',
            'address' => 'required',
            'designation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ward_id.required' => 'Please select ward',
            'name.required' => 'Please enter name',
            'contact_number.required' => 'Please enter contact number',
            'contact_number.numeric' => 'Please enter only number',
            'party_id.required' => 'Please select party',
            'address.required' => 'Please enter address',
            'designation.required' => 'Please enter designation',
        ];
    }
}
