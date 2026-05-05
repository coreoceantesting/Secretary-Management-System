<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoshwaraRequest extends FormRequest
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
                'outward_no' => 'required',
                'goshwarafile' => "nullable|mimes:pdf,PDF",
                'subject' => 'required'
            ];
        } else {
            $rule = [
                'outward_no' => 'required',
                'goshwarafile' => 'required|mimes:pdf,PDF',
                'subject' => 'required'
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'outward_no.required' => 'Please enter outward no',
            'goshwarafile.required' => 'Please select file',
            'goshwarafile.mimes' => 'Only PDF file is supported',
            'subject.required' => 'Please enter remark'
        ];
    }
}
