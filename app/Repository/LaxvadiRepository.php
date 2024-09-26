<?php

namespace App\Repository;

use App\Models\AssignScheduleMeetingDepartment;
use App\Models\Laxvadi;
use App\Models\LaxvadiSubQuestion;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaxvadiRepository
{
    public function index()
    {
        $laxvadi =  Laxvadi::with(['department', 'meeting', 'scheduleMeeting.parentLatestScheduleMeeting', 'laxvadiSubQuestions'])->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->where('meeting_id', Auth::user()->meeting_id);
        })->when(Auth::user()->roles[0]->name == "Department", function ($q) {
            return $q->where('department_id', Auth::user()->department_id);
        })->when(Auth::user()->roles[0]->name == "Department", function ($q) {
            return $q->whereHas('laxvadiSubQuestions', function ($q) {
                $q->where('is_sended', 1);
            });
        })->latest()->get();

        return $laxvadi;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('uploadfile')) {
                $file = $request->uploadfile->store('laxvadis');
            }

            $request['question_file'] = $file;
            $ques = Laxvadi::create($request->all());

            if (isset($request->question)) {
                for ($i = 0; $i < count($request->question); $i++) {
                    $laxvadiSubQuestion = new LaxvadiSubQuestion;
                    $laxvadiSubQuestion->laxvadi_id = $ques->id;
                    $laxvadiSubQuestion->question = $request->question[$i];
                    $laxvadiSubQuestion->member_id = $request->member_id[$i];
                    $laxvadiSubQuestion->save();
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
        return Laxvadi::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $laxvadi = Laxvadi::find($id);
            $file = $laxvadi->question_file;
            if ($request->hasFile('uploadfile')) {
                if ($laxvadi->question_file != "") {
                    if (Storage::exists($laxvadi->question_file)) {
                        Storage::delete($laxvadi->question_file);
                    }
                }
                $file = $request->uploadfile->store('laxvadis');
            }

            $request['question_file'] = $file;
            $laxvadi->update($request->all());

            if (isset($request->question)) {
                LaxvadiSubQuestion::where('laxvadi_id', $id)->delete();
                for ($i = 0; $i < count($request->question); $i++) {
                    $laxvadiSubQuestion = new LaxvadiSubQuestion;
                    $laxvadiSubQuestion->laxvadi_id = $id;
                    $laxvadiSubQuestion->question = $request->question[$i];
                    $laxvadiSubQuestion->member_id = $request->member_id[$i];
                    $laxvadiSubQuestion->save();
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
            $laxvadi = Laxvadi::find($id);
            if ($laxvadi->question_file != "") {
                if (Storage::exists($laxvadi->question_file)) {
                    Storage::delete($laxvadi->question_file);
                }
            }

            $laxvadi->delete();
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
        return LaxvadiSubQuestion::where('laxvadi_id', $id)
            ->when(Auth::user()->roles[0]->name == "Department", function ($q) {
                $q->where('is_sended', 1);
            })
            ->with('member')
            ->get();
    }

    public function show($id)
    {
        return Laxvadi::with(['meeting', 'scheduleMeeting.parentLatestScheduleMeetings'])
            ->where('id', $id)
            ->first();
    }

    public function response($request)
    {
        DB::beginTransaction();
        try {
            $laxvadi = Laxvadi::find($request->id);
            $file = $laxvadi->response_file;
            if ($request->hasFile('responsefile')) {
                if ($laxvadi->response_file != "") {
                    if (Storage::exists($laxvadi->response_file)) {
                        Storage::delete($laxvadi->response_file);
                    }
                }
                $file = $request->responsefile->store('laxvadis');
            }

            $request['response_file'] = $file;
            $laxvadi->update($request->all());

            if (isset($request->response)) {
                for ($i = 0; $i < count($request->response); $i++) {
                    LaxvadiSubQuestion::updateOrCreate([
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
            LaxvadiSubQuestion::updateOrCreate([
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
    public function getScheduleMeetingDepartments($id, $laxvadiId)
    {
        // get schedule meeting assign Id
        if ($laxvadiId == "add")
            $scheduleMeetingQuestionIds = Laxvadi::where('schedule_meeting_id', $id)->pluck('department_id');
        else
            $scheduleMeetingQuestionIds = Laxvadi::where('schedule_meeting_id', $id)->where('id', '!=', $laxvadiId)->pluck('department_id');

        $data = AssignScheduleMeetingDepartment::with(['department'])->whereNotIn('department_id', $scheduleMeetingQuestionIds)->where('schedule_meeting_id', $id)->get();

        return $data;
    }

    // accpet question by mayor
    public function acceptMayorQuetion($request)
    {
        $laxvadiSubQuestion = LaxvadiSubQuestion::find($request->id);
        $laxvadiSubQuestion->is_mayor_selected = 1;
        $laxvadiSubQuestion->save();

        return true;
    }

    // send question to department
    public function sendQuestionToDepartment($request)
    {
        $laxvadiSubQuestion = LaxvadiSubQuestion::find($request->id);
        $laxvadiSubQuestion->is_sended = 1;
        $laxvadiSubQuestion->save();

        return true;
    }
}
