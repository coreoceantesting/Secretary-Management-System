<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TharavRequest extends FormRequest
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
            'meeting_id' => 'required',
            'schedule_meeting_id' => 'required',
            'remark' => 'required',
            'date' => 'required',
            'time' => 'required',
            'uploadfile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG',
            'department_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'meeting_id.required' => 'Please select meeting',
            'schedule_meeting_id.required' => 'Please select schedule meeting',
            'uploadfile.required' => 'Please select file',
            'uploadfile.mimes' => 'Only image, pdf and doc file supported',
            'date.required' => 'Please enter date',
            'time.required' => 'Please enter time',
            'remark.required' => 'Please enter name',
            'department_id.required' => 'Please select atleast one department'
        ];
    }
}
