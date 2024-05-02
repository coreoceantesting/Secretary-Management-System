<?php

namespace App\Repository;

use App\Models\Attendance;
use App\Models\ScheduleMeeting;
use App\Models\Tharav;

class ReportRepository
{
    public function getScheduleMeeting($request)
    {
        $scheduleMeeting = ScheduleMeeting::with(['meeting', 'agenda'])->where('is_meeting_reschedule', 0)->when(isset($request->from) && $request->from != "", function ($q) use ($request) {
            return $q->whereDate('date', '>=', date('Y-m-d', strtotime($request->from)));
        })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
            return $q->whereDate('date', '<=', date('Y-m-d', strtotime($request->to)));
        })->when(isset($request->status) && $request->status != "", function ($q) use ($request) {
            if ($request->status == "1")
                return $q->where('is_meeting_cancel', 0)->where('is_meeting_completed', 0);
            elseif ($request->status == "2")
                return $q->where('is_meeting_completed', 1);
            else
                return $q->where('is_meeting_cancel', 1);
        })
            ->latest()->get();

        return $scheduleMeeting;
    }

    public function viewScheduleMeetingReport($id)
    {
        return ScheduleMeeting::with(['meeting', 'agenda', 'assignScheduleMeetingDepartment.department'])->where('id', $id)->first();
    }

    public function attendanceMeetingReport($request)
    {
        $attendanceReport = Attendance::withWhereHas('member', function ($q) use ($request) {
            $q->when(isset($request->schedule_meeting_id) && $request->schedule_meeting_id != '', function ($q) use ($request) {
                return $q->where('party_id', $request->party_id)->with('party');
            });
        })->with(['scheduleMeeting.agenda', 'meeting'])
            ->when(isset($request->schedule_meeting_id) && $request->schedule_meeting_id != '', function ($q) use ($request) {
                return $q->where('schedule_meeting_id', $request->schedule_meeting_id);
            })
            ->get();

        return $attendanceReport;
    }

    //funtion for tharav report
    public function getTharavReport($request)
    {
        return Tharav::with(['meeting', 'scheduleMeeting'])
            ->whereHas('scheduleMeeting.assignScheduleMeetingDepartment.department', function ($q) use ($request) {
                if (isset($request->department) && $request->department != '') {
                    return $q->where('department_id', $request->department);
                }
            })->when(isset($request->from) && $request->from != "", function ($q) use ($request) {
                return $q->whereDate("date", ">=", $request->from);
            })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
                return $q->whereDate("date", "<=", $request->to);
            })->toSql();
    }
}
