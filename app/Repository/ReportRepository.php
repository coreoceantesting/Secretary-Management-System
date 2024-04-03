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
        })->latest()->get();

        return $scheduleMeeting;
    }
}
