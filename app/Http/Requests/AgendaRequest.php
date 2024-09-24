<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RequiredOne;

class AgendaRequest extends FormRequest
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
                'agendafile' => "nullable|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG|max:2010",
                'subject' => 'required',
                'goshwara_id' => ['required', new RequiredOne]
            ];
        } else {
            $rule = [
                'agendafile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG|max:2010',
                'subject' => 'required',
                'goshwara_id' => ['required', new RequiredOne]
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'agendafile.required' => 'Please select file',
            'agendafile.mimes' => 'Only image, pdf and doc file supported',
            'agendafile.max' => 'File must be less than 2mb',
            'subject.required' => 'Please enter subject',
            'goshwara_id.required' => 'Please check atleast one meeting'
        ];
    }
}
