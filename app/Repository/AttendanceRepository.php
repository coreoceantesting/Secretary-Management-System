<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\Attendance;
use App\Models\AssignMemberToMeeting;
use App\Models\DepartmentAttendance;
use App\Models\SuplimentryAgenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AttendanceRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['agenda', 'meeting'])
            ->where([
                'is_meeting_reschedule' => 0,
                'is_record_proceeding' => 0,
                'is_meeting_cancel' => 0,
                'is_meeting_completed' => 0
            ])->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->where('meeting_id', Auth::user()->meeting_id);
            })->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->member_id)) {
                Attendance::where('schedule_meeting_id', $request->schedule_meeting_id)->delete();
                // ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

                ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                    'meeting_end_date' => ($request->meeting_end_date) ? date('Y-m-d', strtotime($request->meeting_end_date)) : null,
                    'meeting_end_time' => ($request->meeting_end_time) ? date('h:i:s', strtotime($request->meeting_end_time)) : null,
                    'meeting_end_reason' => $request->meeting_end_reason
                ]);

                // SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
                //     'is_meeting_completed' => 1
                // ]);
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


                DepartmentAttendance::where('schedule_meeting_id', $request->schedule_meeting_id)->delete();

                for ($i = 0; $i < count($request->department_attendance_id); $i++) {
                    // Log::info($request->department_in_time[$i]);
                    $inTime = null;
                    if ($request->department_in_time[$i] != "") {
                        $inTime = date('h:i:s', strtotime($request->department_in_time[$i]));
                    }

                    $outTime = null;
                    if ($request->department_out_time[$i] != "") {
                        $outTime = date('h:i:s', strtotime($request->department_out_time[$i]));
                    }

                    if ($request->department_in_time[$i] != "") {
                        $departmentAttendance = new DepartmentAttendance;
                        $departmentAttendance->schedule_meeting_id = $request->schedule_meeting_id;
                        $departmentAttendance->meeting_id = $request->meeting_id;
                        $departmentAttendance->department_id  = $request->department_id[$i];
                        $departmentAttendance->name  = $request->department_name[$i];
                        $departmentAttendance->in_time = $inTime;
                        $departmentAttendance->out_time = $outTime;
                        $departmentAttendance->save();
                    }
                }
            }



            if (isset($request->close_meeting)) {
                ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                    'is_meeting_completed' => 1,
                    'meeting_end_date' => ($request->meeting_end_date) ? date('Y-m-d', strtotime($request->meeting_end_date)) : null,
                    'meeting_end_time' => ($request->meeting_end_time) ? date('h:i:s', strtotime($request->meeting_end_time)) : null,
                    'meeting_end_reason' => $request->meeting_end_reason
                ]);

                SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
                    'is_meeting_completed' => 1
                ]);
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
        return ScheduleMeeting::with(['agenda', 'meeting'])->where('id', $id)->first();
    }

    public function getMeetingMembers($meetingId)
    {
        return AssignMemberToMeeting::with(['member.party'])->where('meeting_id', $meetingId)->get();
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

    public function getDepartmentPresentAttendence($id)
    {
        return DepartmentAttendance::where('schedule_meeting_id', $id)->get();
    }

    public function updateSingleMemberAttandance($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            // ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

            // SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
            //     'is_meeting_completed' => 1
            // ]);

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

    public function saveDepartmentSingleMark($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            // ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

            // SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
            //     'is_meeting_completed' => 1
            // ]);

            if ($request->dataDepartmentAttendanceId != "") {
                $department = DepartmentAttendance::updateOrCreate([
                    'id' => $request->dataDepartmentAttendanceId
                ], [
                    'schedule_meeting_id' => $request->schedule_meeting_id,
                    'meeting_id' => $request->meeting_id,
                    'department_id' => $request->department_id,
                    'name' => $request->name,
                    'in_time' => ($request->inTime != "") ? date('h:i:s', strtotime($request->inTime)) : null,
                    'out_time' => ($request->outTime != "") ? date('h:i:s', strtotime($request->outTime)) : null,
                ]);
            } else {
                $department = DepartmentAttendance::create([
                    'schedule_meeting_id' => $request->schedule_meeting_id,
                    'meeting_id' => $request->meeting_id,
                    'department_id' => $request->department_id,
                    'name' => $request->name,
                    'in_time' => ($request->inTime != "") ? date('h:i:s', strtotime($request->inTime)) : null,
                    'out_time' => ($request->outTime != "") ? date('h:i:s', strtotime($request->outTime)) : null,
                ]);
            }
            return [true, $department->id];
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return [false, $department->id];
        }
    }
}
