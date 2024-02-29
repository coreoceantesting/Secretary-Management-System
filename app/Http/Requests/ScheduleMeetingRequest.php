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
        if ($this->id) {
            $rule = [
                'agendafile' => "nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf,PDF,doc,DOC,docx,DOCX,xlsx, xls|max:2010",
                'meeting_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'place' => 'required',
            ];
        } else {
            $rule = [
                'agendafile' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf,PDF,doc,DOC,docx,DOCX,xlsx, xls|max:2010',
                'meeting_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'place' => 'required',
            ];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'agendafile.required' => 'Please select file',
            'agendafile.mimes' => 'Only jpg, png, pdf, doc and xls file supported only',
            'agendafile.max' => 'File must be less than 2mb',
            'meeting_id.required' => 'Please select meeting',
            'date.required' => 'Please select date',
            'time.required' => 'Please select time',
            'time.place' => 'Please enter place',
        ];
    }
}
