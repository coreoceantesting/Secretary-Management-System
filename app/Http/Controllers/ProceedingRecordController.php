<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProceedingRecordRepository;
use App\Repository\CommonRepository;
use App\Models\Agenda;
use App\Models\SuplimentryAgenda;
use App\Models\AssignMemberToMeeting;
use App\Models\Member;
use App\Models\Question;
use App\Models\ScheduleMeeting;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\ProceedingRecord;
use App\Http\Requests\ProceedingRecordRequest;

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
                'scheduleMeetings' => $scheduleMeetings
            ]);
        }
    }

    public function store(ProceedingRecordRequest $request)
    {
        $proceedingRecord = $this->proceedingRecordRepository->store($request);

        if ($proceedingRecord) {
            return response()->json(['success' => 'Proceeding Record created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function show($id)
    {
        $proceedingRecord = ProceedingRecord::with(['meeting'])->find($id);

        $scheduleMeeting = ScheduleMeeting::where('id', $proceedingRecord->schedule_meeting_id)->first();

        $agenda = Agenda::where('id', $scheduleMeeting->agenda_id)->first();

        $scheduleMeetings = ScheduleMeeting::with(['meeting'])
            ->where('parent_id', $scheduleMeeting->parent_id)
            ->get();
        $ids = $scheduleMeetings->pluck('id')->toArray();

        $members = AssignMemberToMeeting::with(['member.attendance' => function ($q) use ($proceedingRecord) {
            return $q->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id);
        }])->where('meeting_id', $proceedingRecord->meeting_id)->get();


        $departments = AssignScheduleMeetingDepartment::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id)
            ->get();

        $suplimentryAgendas = SuplimentryAgenda::whereIn('schedule_meeting_id', $ids)->get();

        $questions = Question::whereIn('schedule_meeting_id', $ids)->get();

        return view('proceeding-record.show')->with([
            'agenda' => $agenda,
            'scheduleMeetings' => $scheduleMeetings,
            'proceedingRecord' => $proceedingRecord,
            'members' => $members,
            'departments' => $departments,
            'suplimentryAgendas' => $suplimentryAgendas,
            'questions' => $questions
        ]);
    }
}
