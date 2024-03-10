<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\Goshwara;
use App\Models\Agenda;
use App\Models\SuplimentryAgenda;
use App\Models\ScheduleMeeting;
use App\Models\RescheduleMeeting;
use App\Models\Question;
use App\Models\ProceedingRecord;
use App\Models\Tharav;

class DashboardController extends Controller
{

    public function index()
    {
        $goshwara = Goshwara::count();

        $agenda = Agenda::count();

        $suplimentryAgenda = SuplimentryAgenda::count();

        $scheduleMeeting = ScheduleMeeting::whereNull('schedule_meeting_id')->where('is_meeting_reschedule', 0)->count();

        $rescheduleMeeting = ScheduleMeeting::whereNotNull('schedule_meeting_id')->where('is_meeting_reschedule', 0)->count();

        $question = Question::count();

        $proceedingRecord = ProceedingRecord::count();

        $tharav = Tharav::count();

        return view('dashboard')->with([
            'goshwara' => $goshwara,
            'agenda' => $agenda,
            'suplimentryAgenda' => $suplimentryAgenda,
            'scheduleMeeting' => $scheduleMeeting,
            'rescheduleMeeting' => $rescheduleMeeting,
            'question' => $question,
            'proceedingRecord' => $proceedingRecord,
            'tharav' => $tharav,
        ]);
    }

    public function changeThemeMode()
    {
        $mode = request()->cookie('theme-mode');

        if ($mode == 'dark')
            Cookie::queue('theme-mode', 'light', 43800);
        else
            Cookie::queue('theme-mode', 'dark', 43800);

        return true;
    }
}
