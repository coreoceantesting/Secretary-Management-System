<?php

namespace App\Repository;

use App\Models\Question;
use App\Models\QuestionDepartment;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\SubQuestion;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionRepository
{
    public function index()
    {
        $question =  Question::with(['department', 'meeting', 'scheduleMeeting.parentLatestScheduleMeeting', 'subQuestions'])->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->where('meeting_id', Auth::user()->meeting_id);
        })->when(Auth::user()->roles[0]->name == "Department", function ($q) {
            return $q->where('department_id', Auth::user()->department_id);
        })->when(Auth::user()->roles[0]->name == "Department", function ($q) {
            return $q->whereHas('subQuestions', function ($q) {
                $q->where('is_sended', 1);
            });
        })->latest()->get();

        return $question;
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
            $ques = Question::create($request->all());

            if (isset($request->question)) {
                for ($i = 0; $i < count($request->question); $i++) {
                    $subQuestion = new SubQuestion;
                    $subQuestion->question_id = $ques->id;
                    $subQuestion->question = $request->question[$i];
                    $subQuestion->save();
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
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

            if (isset($request->question)) {
                SubQuestion::where('question_id', $id)->delete();
                for ($i = 0; $i < count($request->question); $i++) {
                    $subQuestion = new SubQuestion;
                    $subQuestion->question_id = $id;
                    $subQuestion->question = $request->question[$i];
                    $subQuestion->save();
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
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
            DB::rollback();
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

    public function getSubQuestions($id)
    {
        return SubQuestion::where('question_id', $id)
            ->when(Auth::user()->roles[0]->name == "Department", function ($q) {
                $q->where('is_sended', 1);
            })
            ->get();
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

            if (isset($request->response)) {
                for ($i = 0; $i < count($request->response); $i++) {
                    SubQuestion::updateOrCreate([
                        'id' => $request->subQuestionId[$i]
                    ], [
                        'response' => $request->response[$i]
                    ]);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function saveSingleResponse($request)
    {
        DB::beginTransaction();
        try {
            SubQuestion::updateOrCreate([
                'id' => $request->id
            ], [
                'response' => $request->response
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    // function to get schedule meeting departments id
    public function getScheduleMeetingDepartments($id, $questionId)
    {
        // get schedule meeting assign Id
        if ($questionId == "add")
            $scheduleMeetingQuestionIds = Question::where('schedule_meeting_id', $id)->pluck('department_id');
        else
            $scheduleMeetingQuestionIds = Question::where('schedule_meeting_id', $id)->where('id', '!=', $questionId)->pluck('department_id');

        $data = AssignScheduleMeetingDepartment::with(['department'])->whereNotIn('department_id', $scheduleMeetingQuestionIds)->where('schedule_meeting_id', $id)->get();

        return $data;
    }

    // accpet question by mayor
    public function acceptMayorQuetion($request)
    {
        $subQuestion = SubQuestion::find($request->id);
        $subQuestion->is_mayor_selected = 1;
        $subQuestion->save();

        return true;
    }

    // send question to department
    public function sendQuestionToDepartment($request)
    {
        $subQuestion = SubQuestion::find($request->id);
        $subQuestion->is_sended = 1;
        $subQuestion->save();

        return true;
    }
}
