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
        if ($this->edit_model_id) {
            return [
                'name' => "required|unique:meetings,name,$this->edit_model_id,id,deleted_at,NULL",
                'head_person_name' => 'required',
                'head_person_designation' => 'required',
                'member_id' => 'required'
            ];
        } else {
            return [
                'name' => "required|unique:meetings,name,NULL,NULL,deleted_at,NULL",
                'head_person_name' => 'required',
                'head_person_designation' => 'required',
                'member_id' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'name' => 'Please enter name',
            'name.unique' => $this->name . ' name already exists in meeting.',
            'head_person_name' => 'Please enter head person name',
            'head_person_designation' => 'Please enter head person designation',
            'member_id' => 'Please select atleast one member'
        ];
    }
}
