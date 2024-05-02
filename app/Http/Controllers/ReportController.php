<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ReportRepository;
use App\Models\Party;
use App\Models\ScheduleMeeting;
use App\Models\Department;

class ReportController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function scheduleMeetingReport(Request $request)
    {
        $scheduleMeetings = $this->reportRepository->getScheduleMeeting($request);

        return view('report.schedule-meeting')->with([
            'scheduleMeetings' => $scheduleMeetings
        ]);
    }

    public function viewScheduleMeetingReport($id)
    {
        $scheduleMeeting = $this->reportRepository->viewScheduleMeetingReport($id);

        return view('report.schedule-meeting-view')->with(['scheduleMeeting' => $scheduleMeeting]);
    }

    public function attendanceMeetingReport(Request $request)
    {
        $attendanceMeetingReports = $this->reportRepository->attendanceMeetingReport($request);

        $scheduleMeetings = ScheduleMeeting::where([
            'is_meeting_cancel' => 0,
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 1
        ])->get();

        $parties = Party::all();

        return view('report.attendance-meeting')->with([
            'attendanceMeetingReports' => $attendanceMeetingReports,
            'parties' => $parties,
            'scheduleMeetings' => $scheduleMeetings
        ]);
    }

    // function for tharav report
    public function tharavReport(Request $request)
    {
        $tharavs = $this->reportRepository->getTharavReport($request);

        $departments = Department::where('is_home_department', 0)->get();

        return view('report.tharav')->with([
            'tharavs' => $tharavs,
            'departments' => $departments
        ]);
    }
}
