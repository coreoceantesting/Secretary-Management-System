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
                'name' => 'required',
                'goshwarafile' => "nullable|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG",
                'subject' => 'required'
            ];
        } else {
            $rule = [
                'name' => 'required',
                'goshwarafile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG',
                'subject' => 'required'
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'goshwarafile.required' => 'Please select file',
            'goshwarafile.mimes' => 'Only image, pdf and doc file supported',
            'subject.required' => 'Please enter remark'
        ];
    }
}
