<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProceedingRecordRepository;
use App\Repository\CommonRepository;

class ProceedingRecordController extends Controller
{
    protected $proceedingRecordRepository;
    protected $commonRepository;

    public function __construct(ProceedingRecordRepository $proceedingRecordRepository, CommonRepository $commonRepository)
    {
        $this->proceedingRecordRepository = $proceedingRecordRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $proceedingRecords = $this->proceedingRecordRepository->index();

        $meetings = $this->commonRepository->getCompletedMeeting();

        return view('proceeding-record.index')->with([
            'proceedingRecords' => $proceedingRecords,
            'meetings' => $meetings
        ]);
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->proceedingRecordRepository->getScheduleMeeting($id);

            $results = $scheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  date('d-m-Y h:i A', strtotime($item["datetime"]));
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'scheduleMeetings' => $results
            ]);
        }
    }

    public function store(Request $request)
    {
        $proceedingRecord = $this->proceedingRecordRepository->store($request);

        if ($proceedingRecord) {
            return response()->json(['success' => 'Proceeding Record created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
