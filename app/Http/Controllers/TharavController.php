<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TharavRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\TharavRequest;

class TharavController extends Controller
{
    protected $tharavRepository;
    protected $commonRepository;

    public function __construct(TharavRepository $tharavRepository, CommonRepository $commonRepository)
    {
        $this->tharavRepository = $tharavRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $tharavs  = $this->tharavRepository->index();

        $meetings = $this->commonRepository->getGeneratedProceedingRecordMeeting();

        return view('tharav.index')->with([
            'tharavs' => $tharavs,
            'meetings' => $meetings
        ]);
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->tharavRepository->getScheduleMeeting($id);

            $results = $scheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  date('d-m-Y h:i A', strtotime($item["datetime"]));
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'scheduleMeetings' => $scheduleMeetings
            ]);
        }
    }

    public function getScheduleMeetingDepartment(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->tharavRepository->getScheduleMeetingDepartment($id);
            $departmentHtml = "";

            $departmentHtml .= '<option value="" disabled>Select Department</option>';
            foreach ($scheduleMeetings as $scheduleMeeting) {
                $departmentHtml .= '<option value="' . $scheduleMeeting->department_id . '">' . $scheduleMeeting->department?->name . '</option>';
            }

            return response()->json([
                'status' => 200,
                'department' => $departmentHtml
            ]);
        }
    }

    public function store(TharavRequest $request)
    {
        $tharavRepository = $this->tharavRepository->store($request);

        if ($tharavRepository) {
            return response()->json(['success' => 'Tharav created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
