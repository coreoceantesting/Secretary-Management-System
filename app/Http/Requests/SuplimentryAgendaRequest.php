<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuplimentryAgendaRequest extends FormRequest
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
                'schedule_meeting_id' => 'required',
                'subject' => 'required',
                'agendafile' => 'nullable|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG',
            ];
        } else {
            return [
                'schedule_meeting_id' => 'required',
                'subject' => 'required',
                'agendafile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX,png,PNG,jpg,JPG,jpeg,JPEG',
            ];
        }
    }

    public function messages()
    {
        return [
            'agendafile.required' => 'Please select file',
            'agendafile.mimes' => 'Only image, pdf and doc file supported',
            'name.required' => 'Please enter name',
            'schedule_meeting_id.required' => 'Please Select Schedule Meeting'
        ];
    }
}
