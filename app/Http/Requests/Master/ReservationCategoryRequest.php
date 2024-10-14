<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class ReservationCategoryRequest extends FormRequest
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
            return [
                'name' => "required|unique:reservation_categories,name,$this->edit_model_id,id,deleted_at,NULL"
            ];
        } else {
            return [
                'name' => 'required|unique:reservation_categories,name,NULL,NULL,deleted_at,NULL'
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
        ];
    }
}
