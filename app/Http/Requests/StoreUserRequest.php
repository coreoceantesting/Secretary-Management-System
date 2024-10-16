<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'department_id' => 'nullable',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'contact' => 'required|unique:users,contact|digits:10',
            'email' => 'required|unique:users,email|email',
            'gender' => 'required',
            'dob' => 'required',
            'role' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }
}
