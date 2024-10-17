<?php

namespace App\Repository;

use App\Models\Ward;
use App\Models\Meeting;
use App\Models\Agenda;
use App\Models\Department;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMeeting;

class CommonRepository
{
    public function getWardMember()
    {
        return Ward::with(['members'])->get();
    }

    public function getMeeting()
    {
        return Meeting::when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();
    }

    public function getRescheduleMeeting()
    {
        return Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->where([
                'is_meeting_cancel' => 0,
                'is_meeting_reschedule' => 0,
                'is_meeting_completed' => 0
            ]);
        })->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();
    }

    public function getCompletedMeeting()
    {
        $meeting = Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->where('is_meeting_completed', 1)->where('is_record_proceeding', 0);
        })->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();

        return $meeting;
    }

    public function getGeneratedProceedingRecordMeeting()
    {
        $meeting = Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->where([
                'is_meeting_completed' => 1,
                'is_record_proceeding' => 1,
                'is_tharav_uploaded' => 0,
            ]);
        })->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();

        return $meeting;
    }

    public function getSeventDayMeeting()
    {
        $meeting = Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->whereDate('date', '>=', date('Y-m-d', strtotime('+7 days')));
        })->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();

        return $meeting;
    }

    public function getNotScheduleMeetingAgenda($id = null)
    {
        $agenda = Agenda::where('is_meeting_schedule', 0)
            ->where('is_mayor_view', 1)
            ->when($id, function ($q) use ($id) {
                $q->orWhere('id', $id);
            })->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->whereIn('meeting_id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
            })->get();

        return $agenda;
    }

    public function getDepartments()
    {
        return Department::where('is_home_department', 0)->get();
    }

    public function checkMeetingExist($request)
    {
        $check = ScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
            ->where('time', date('H:i:s', strtotime($request->time)))
            ->where('meeting_id', $request->meeting_id)->exists();

        return $check;
    }

    public function checkEditMeetingExist($request, $id)
    {
        $check = ScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
            ->whereDate('meeting_id', $request->meeting_id)->where('id', '!=', $id)->exists();

        return $check;
    }
}
