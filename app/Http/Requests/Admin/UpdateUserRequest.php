<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'contact' => 'required|digits:10',
            'email' => 'required|email',
            'gender' => 'required',
            'dob' => 'required',
            'role' => 'required',
            'username' => 'required',
        ];
    }
}