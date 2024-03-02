<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\Attendance;
use App\Models\AssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['agenda', 'meeting'])->where('date', date('Y-m-d'))->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            if (isset($request->member_id)) {
                Attendance::where('schedule_meeting_id', $request->schedule_meeting_id)->delete();
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
        return ScheduleMeeting::with(['agenda', 'meeting'])->where('date', date('Y-m-d'))->where('id', $id)->first();
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
}
