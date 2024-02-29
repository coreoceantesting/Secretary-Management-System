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
        return Question::with(['meeting', 'scheduleMeeting'])->latest()->get();
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
        return ScheduleMeeting::where('meeting_id', $id)->get();
    }
}
