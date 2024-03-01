<?php

namespace App\Repository;

use App\Models\Ward;
use App\Models\Meeting;
use App\Models\Agenda;
use App\Models\Department;
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
}
