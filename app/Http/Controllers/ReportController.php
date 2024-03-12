<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ReportRepository;

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
}
