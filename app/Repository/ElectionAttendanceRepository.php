<?php

namespace App\Repository;

use App\Models\ElectionScheduleMeeting;
use App\Models\ElectionAttendance;
use App\Models\AssignMemberToMeeting;
use App\Models\ElectionAssignMemberToMeeting;
use App\Models\ElectionDepartmentAttendance;
use App\Models\ElectionSuplimentryAgenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ElectionAttendanceRepository
{
    public function index()
    {
        return ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting'])
            ->where([
                'is_meeting_reschedule' => 0,
                'is_meeting_cancel' => 0,
                'is_meeting_completed' => 0
            ])->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->member_id)) {
                ElectionAttendance::where('election_schedule_meeting_id', $request->election_schedule_meeting_id)->delete();
                // ScheduleMeeting::where('id', $request->schedule_meeting_id)->update(['is_meeting_completed' => 1]);

                ElectionScheduleMeeting::where('id', $request->election_schedule_meeting_id)->update([
                    'meeting_end_date' => ($request->meeting_end_date) ? date('Y-m-d', strtotime($request->meeting_end_date)) : null,
                    'meeting_end_time' => ($request->meeting_end_time) ? date('H:i:s', strtotime($request->meeting_end_time)) : null,
                    'meeting_end_reason' => $request->meeting_end_reason
                ]);

                // SuplimentryAgenda::where('schedule_meeting_id', $request->schedule_meeting_id)->update([
                //     'is_meeting_completed' => 1
                // ]);
                for ($i = 0; $i < count($request->member_id); $i++) {
                    $inTime = null;
                    if ($request->in_time[$i] != "") {
                        $inTime = date('H:i:s', strtotime($request->in_time[$i]));
                    }

                    $outTime = null;
                    if ($request->out_time[$i] != "") {
                        $outTime = date('H:i:s', strtotime($request->out_time[$i]));
                    }

                    if ($request->in_time[$i] != "") {
                        $attendance = new ElectionAttendance;
                        $attendance->election_schedule_meeting_id = $request->election_schedule_meeting_id;
                        $attendance->election_meeting_id = $request->election_meeting_id;
                        $attendance->member_id = $request->member_id[$i];
                        $attendance->in_time = $inTime;
                        $attendance->out_time = $outTime;
                        $attendance->save();
                    }
                }


                ElectionDepartmentAttendance::where('schedule_meeting_id', $request->election_schedule_meeting_id)->delete();

                for ($i = 0; $i < count($request->department_attendance_id); $i++) {
                    // Log::info($request->department_in_time[$i]);
                    $inTime = null;
                    if ($request->department_in_time[$i] != "") {
                        $inTime = date('H:i:s', strtotime($request->department_in_time[$i]));
                    }

                    $outTime = null;
                    if ($request->department_out_time[$i] != "") {
                        $outTime = date('H:i:s', strtotime($request->department_out_time[$i]));
                    }

                    if ($request->department_in_time[$i] != "") {
                        $departmentAttendance = new ElectionDepartmentAttendance;
                        $departmentAttendance->schedule_meeting_id = $request->election_schedule_meeting_id;
                        $departmentAttendance->election_meeting_id = $request->election_meeting_id;
                        $departmentAttendance->name  = $request->department_name[$i];
                        $departmentAttendance->designation  = $request->designation[$i];
                        $departmentAttendance->in_time = $inTime;
                        $departmentAttendance->out_time = $outTime;
                        $departmentAttendance->save();
                    }
                }
            }



            if (isset($request->close_meeting)) {
                // Log::info('d');
                ElectionScheduleMeeting::where('id', $request->election_schedule_meeting_id)->update([
                    'is_meeting_completed' => 1,
                    'meeting_end_date' => ($request->meeting_end_date) ? date('Y-m-d', strtotime($request->meeting_end_date)) : null,
                    'meeting_end_time' => ($request->meeting_end_time) ? date('H:i:s', strtotime($request->meeting_end_time)) : null,
                    'meeting_end_reason' => $request->meeting_end_reason
                ]);

                ElectionSuplimentryAgenda::where('schedule_meeting_id', $request->election_schedule_meeting_id)->update([
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

    public function edit($id) {}



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
        return ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting'])->where('id', $id)->first();
    }

    public function getMeetingMembers($meetingId)
    {
        return ElectionAssignMemberToMeeting::with(['member.party'])->where('election_meeting_id', $meetingId)->get();
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
        return ElectionAttendance::where('election_schedule_meeting_id', $id)->get();
    }

    public function getDepartmentPresentAttendence($id)
    {
        return ElectionDepartmentAttendance::where('schedule_meeting_id', $id)->get();
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

            ElectionAttendance::updateOrCreate([
                'member_id' => $request->memberId,
                'election_schedule_meeting_id' => $request->election_schedule_meeting_id,
                'election_meeting_id' => $request->election_meeting_id
            ], [
                'election_schedule_meeting_id' => $request->election_schedule_meeting_id,
                'election_meeting_id' => $request->election_meeting_id,
                'member_id' => $request->memberId,
                'in_time' => date('H:i:s', strtotime($request->inTime)),
                'out_time' => ($request->outTime != "") ? date('H:i:s', strtotime($request->outTime)) : null,
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
                $department = ElectionDepartmentAttendance::updateOrCreate([
                    'id' => $request->dataDepartmentAttendanceId
                ], [
                    'schedule_meeting_id' => $request->schedule_meeting_id,
                    'election_meeting_id' => $request->election_meeting_id,
                    'designation' => $request->designation,
                    'name' => $request->name,
                    'in_time' => ($request->inTime != "") ? date('H:i:s', strtotime($request->inTime)) : null,
                    'out_time' => ($request->outTime != "") ? date('H:i:s', strtotime($request->outTime)) : null,
                ]);
            } else {
                $department = ElectionDepartmentAttendance::create([
                    'schedule_meeting_id' => $request->schedule_meeting_id,
                    'election_meeting_id' => $request->election_meeting_id,
                    'designation' => $request->designation,
                    'name' => $request->name,
                    'in_time' => ($request->inTime != "") ? date('H:i:s', strtotime($request->inTime)) : null,
                    'out_time' => ($request->outTime != "") ? date('H:i:s', strtotime($request->outTime)) : null,
                ]);
            }
            return [true, $department->id];
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return [false];
        }
    }
}
