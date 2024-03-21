<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleMeetingRequest extends FormRequest
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
                'agenda_id' => 'required',
                'agendafile' => "nullable|mimes:pdf,PDF,doc,DOC,docx,DOCX|max:2010",
                'meeting_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'place' => 'required',
                'department_id' => 'required'
            ];
        } else {
            $rule = [
                'agenda_id' => 'required',
                'agendafile' => 'required|mimes:pdf,PDF,doc,DOC,docx,DOCX|max:2010',
                'meeting_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'place' => 'required',
                'department_id' => 'required'
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'agenda_id.required' => 'Please select Agenda',
            'agendafile.required' => 'Please select file',
            'agendafile.mimes' => 'Only pdf and doc file supported',
            'agendafile.max' => 'File must be less than 2mb',
            'meeting_id.required' => 'Please select meeting',
            'date.required' => 'Please select date',
            'time.required' => 'Please select time',
            'time.place' => 'Please enter place',
            'department_id.required' => "Please selected atleast one department"
        ];
    }
}
