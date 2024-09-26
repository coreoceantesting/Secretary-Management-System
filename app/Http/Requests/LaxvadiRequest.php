<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaxvadiRequest extends FormRequest
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
                'uploadfile' => "nullable|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG",
                'meeting_id' => 'required',
                'schedule_meeting_id' => 'required',
                'question' => 'required',
                'department_id' => 'required'
            ];
        } else {
            $rule = [
                'uploadfile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG',
                'meeting_id' => 'required',
                'schedule_meeting_id' => 'required',
                'question' => 'required',
                'department_id' => 'required'
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'uploadfile.required' => 'Please select file',
            'uploadfile.mimes' => 'Only image, pdf and doc file supported',
            'meeting_id.required' => 'Please select Meeting',
            'department_id.required' => 'Please select Department',
            'schedule_meeting_id.required' => 'Please select Schedule Meeting Date & Time',
            'question.required' => 'Please enter laxvadi'
        ];
    }
}
