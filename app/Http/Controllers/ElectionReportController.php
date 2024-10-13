<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ElectionReportRepository;
use App\Models\Party;
use App\Models\ElectionScheduleMeeting;
use App\Models\Department;
use App\Models\Meeting;

class ElectionReportController extends Controller
{
    protected $electionReportRepository;

    public function __construct(ElectionReportRepository $electionReportRepository)
    {
        $this->electionReportRepository = $electionReportRepository;
    }

    public function scheduleMeetingReport(Request $request)
    {
        $scheduleMeetings = $this->electionReportRepository->getScheduleMeeting($request);

        return view('election.report.schedule-meeting')->with([
            'scheduleMeetings' => $scheduleMeetings
        ]);
    }

    public function viewScheduleMeetingReport($id)
    {
        $scheduleMeeting = $this->electionReportRepository->viewScheduleMeetingReport($id);
        // return $scheduleMeeting;
        return view('election.report.schedule-meeting-view')->with(['scheduleMeeting' => $scheduleMeeting]);
    }

    public function attendanceMeetingReport(Request $request)
    {
        $attendanceMeetingReports = $this->electionReportRepository->attendanceMeetingReport($request);

        $scheduleMeetings = ElectionScheduleMeeting::where([
            'is_meeting_cancel' => 0,
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 1
        ])->get();

        $parties = Party::all();

        return view('election.report.attendance-meeting')->with([
            'attendanceMeetingReports' => $attendanceMeetingReports,
            'parties' => $parties,
            'scheduleMeetings' => $scheduleMeetings
        ]);
    }
}
