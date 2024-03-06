<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        if ($this->edit_model_id) {
            $rule = [
                'name' => "required|regex:/^[a-zA-Z0-9 ]+$/u|unique:departments,name,$this->id",
                'initial' => 'required'
            ];
        } else {
            $rule = [
                'name' => 'required|unique:departments,name|regex:/^[a-zA-Z0-9 ]+$/u',
                'initial' => 'required'
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'initial.required' => 'Please enter initial',
        ];
    }
}
