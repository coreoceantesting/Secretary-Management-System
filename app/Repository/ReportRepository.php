<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;

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
}
