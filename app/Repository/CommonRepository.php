<?php

namespace App\Repository;

use App\Models\Ward;
use App\Models\Meeting;
use App\Models\Agenda;
use App\Models\Department;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommonRepository
{
    public function getWardMember()
    {
        return Ward::with(['members'])->get();
    }

    public function getMeeting()
    {
        return Meeting::get();
    }

    public function getCompletedMeeting()
    {
        $meeting = Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->where('is_meeting_completed', 1);
        })->get();

        return $meeting;
    }

    public function getSeventDayMeeting()
    {
        $meeting = Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->whereDate('date', '>=', date('Y-m-d', strtotime('+7 days')));
        })->get();

        return $meeting;
    }

    public function getNotScheduleMeetingAgenda($id = null)
    {
        $agenda = Agenda::where('is_meeting_schedule', 0);

        if ($id) {
            $agenda = $agenda->orWhere('id', $id);
        }

        $agenda = $agenda->get();

        return $agenda;
    }

    public function getDepartments()
    {
        return Department::where('is_home_department', 0)->get();
    }

    public function checkMeetingExist($request)
    {
        $check = ScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
            ->whereDate('meeting_id', $request->meeting_id)->exists();

        return $check;
    }

    public function checkEditMeetingExist($request, $id)
    {
        $check = ScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
            ->whereDate('meeting_id', $request->meeting_id)->where('id', '!=', $id)->exists();

        return $check;
    }
}
