<?php

namespace App\Repository;

use App\Models\Question;
use App\Models\QuestionDepartment;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QuestionRepository
{
    public function index()
    {
        return Question::with(['meeting', 'scheduleMeeting.parentLatestScheduleMeeting'])->latest()->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('uploadfile')) {
                $file = $request->uploadfile->store('questions');
            }

            $request['question_file'] = $file;
            Question::create($request->all());

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function edit($id)
    {
        return Question::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $question = Question::find($id);
            $file = $question->question_file;
            if ($request->hasFile('uploadfile')) {
                if ($question->question_file != "") {
                    if (Storage::exists($question->question_file)) {
                        Storage::delete($question->question_file);
                    }
                }
                $file = $request->uploadfile->store('questions');
            }

            $request['question_file'] = $file;
            $question->update($request->all());

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $question = Question::find($id);
            if ($question->question_file != "") {
                if (Storage::exists($question->question_file)) {
                    Storage::delete($question->question_file);
                }
            }

            $question->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where('meeting_id', $id)->where([
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 0,
            'is_meeting_cancel' => 0,
        ])->get();
    }

    public function show($id)
    {
        return Question::with(['meeting', 'scheduleMeeting.parentLatestScheduleMeeting'])
            ->where('id', $id)
            ->first();
    }

    public function response($request)
    {
        DB::beginTransaction();
        try {
            $question = Question::find($request->id);
            $file = $question->response_file;
            if ($request->hasFile('responsefile')) {
                if ($question->response_file != "") {
                    if (Storage::exists($question->response_file)) {
                        Storage::delete($question->response_file);
                    }
                }
                $file = $request->responsefile->store('questions');
            }

            $request['response_file'] = $file;
            $question->update($request->all());

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
