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
        return [
            'schedule_meeting_id' => 'required',
            'name' => 'required',
            'agendafile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX|max:2010',
        ];
    }

    public function messages()
    {
        return [
            'agendafile.required' => 'Please select file',
            'agendafile.mimes' => 'Only pdf and doc file supported',
            'agendafile.max' => 'File must be less than 2mb',
            'name.required' => 'Please enter name',
            'schedule_meeting_id' => 'Please Select Schedule Meeting'
        ];
    }
}
