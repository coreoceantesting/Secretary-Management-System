<?php

namespace App\Repository;

use App\Models\ElectionAttendance;
use App\Models\ElectionScheduleMeeting;

class ElectionReportRepository
{
    public function getScheduleMeeting($request)
    {
        $scheduleMeeting = ElectionScheduleMeeting::with(['electionMeeting', 'electionAgenda'])->where('is_meeting_reschedule', 0)->when(isset($request->from) && $request->from != "", function ($q) use ($request) {
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
        return ElectionScheduleMeeting::with(['electionMeeting', 'electionAgenda', 'assignScheduleMeetingDepartment.department', 'proceedingRecord.electionMeeting'])->where('id', $id)->first();
    }

    public function attendanceMeetingReport($request)
    {
        $attendanceReport = ElectionAttendance::withWhereHas('member', function ($q) use ($request) {
            $q->when(isset($request->party_id) && $request->party_id != '', function ($q) use ($request) {
                return $q->where('party_id', $request->party_id)->with('party');
            });
        })->with(['electionScheduleMeeting.electionAgenda', 'electionMeeting'])
            ->when(isset($request->schedule_meeting_id) && $request->schedule_meeting_id != '', function ($q) use ($request) {
                return $q->where('election_schedule_meeting_id', $request->schedule_meeting_id);
            })
            ->get();

        return $attendanceReport;
    }

    //funtion for tharav report
    public function getTharavReport($request)
    {
        return Tharav::with(['meeting', 'scheduleMeeting'])
            ->whereHas('scheduleMeeting.assignScheduleMeetingDepartment', function ($q) use ($request) {
                if (isset($request->department) && $request->department != '') {
                    return $q->where('department_id', $request->department)->with('department');
                }
            })->when(isset($request->from) && $request->from != "", function ($q) use ($request) {
                return $q->whereDate("date", ">=", $request->from);
            })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
                return $q->whereDate("date", "<=", $request->to);
            })->get();
    }

    public function getQuestionResponse($request)
    {
        return Question::with(['meeting'])->withWherehas('subQuestions', function ($q) use ($request) {
            $q->when(isset($request->from) && $request->from != "", function ($q) use ($request) {
                $q->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->from)));
            })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
                $q->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->to)));
            })->whereNotNull('response')->orderBy('response_datetime', 'asc')->with(['member']);
        })->when(isset($request->meeting) && $request->meeting != "", function ($q) use ($request) {
            $q->where('meeting_id', $request->meeting);
        })->latest()->get();
    }
}
