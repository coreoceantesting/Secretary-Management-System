<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\Attendance;
use App\Models\AssignMemberToMeeting;
use App\Models\SuplimentryAgenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['agenda', 'meeting'])
            ->where(
                ['is_meeting_reschedule' => 0, 'is_record_proceeding' => 0, 'is_meeting_cancel' => 0]
            )->whereDate('date', '>', date('Y-m-d'))->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            if (isset($request->member_id)) {
                Attendance::where('schedule_meeting_id', $request->schedule_meeting_id)->delete();
                ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

                SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
                    'is_meeting_completed' => 1
                ]);
                for ($i = 0; $i < count($request->member_id); $i++) {
                    $inTime = null;
                    if ($request->in_time[$i] != "") {
                        $inTime = date('h:i:s', strtotime($request->in_time[$i]));
                    }

                    $outTime = null;
                    if ($request->out_time[$i] != "") {
                        $outTime = date('h:i:s', strtotime($request->out_time[$i]));
                    }

                    if ($request->in_time[$i] != "") {
                        $attendance = new Attendance;
                        $attendance->schedule_meeting_id = $request->schedule_meeting_id;
                        $attendance->meeting_id = $request->meeting_id;
                        $attendance->member_id = $request->member_id[$i];
                        $attendance->in_time = $inTime;
                        $attendance->out_time = $outTime;
                        $attendance->save();
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function edit($id)
    {
    }



    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function show($id)
    {
        return ScheduleMeeting::with(['agenda', 'meeting', 'suplimentryAgenda'])->where('id', $id)->first();
    }

    public function getMeetingMembers($meetingId)
    {
        return AssignMemberToMeeting::with(['member'])->where('meeting_id', $meetingId)->get();
    }



    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }


    public function getPresentAttendence($id)
    {
        return Attendance::where('schedule_meeting_id', $id)->get();
    }


    public function updateSingleMemberAttandance($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

            SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
                'is_meeting_completed' => 1
            ]);

            Attendance::updateOrCreate([
                'member_id' => $request->memberId,
                'schedule_meeting_id' => $request->schedule_meeting_id,
                'meeting_id' => $request->meeting_id
            ], [
                'schedule_meeting_id' => $request->schedule_meeting_id,
                'meeting_id' => $request->meeting_id,
                'member_id' => $request->memberId,
                'in_time' => date('h:i:s', strtotime($request->inTime)),
                'out_time' => ($request->outTime != "") ? date('h:i:s', strtotime($request->outTime)) : null,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }
}
