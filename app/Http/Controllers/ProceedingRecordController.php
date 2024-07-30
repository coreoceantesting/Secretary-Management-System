<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProceedingRecordRepository;
use App\Repository\CommonRepository;
use App\Models\Agenda;
use App\Models\Department;
use App\Models\SuplimentryAgenda;
use App\Models\AssignMemberToMeeting;
use App\Models\DepartmentAttendance;
use App\Models\Question;
use App\Models\ScheduleMeeting;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\ProceedingRecord;
use App\Http\Requests\ProceedingRecordRequest;
use PDF;

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
                $item["datetime"] =  $item['unique_id'] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
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
        $proceedingRecord = ProceedingRecord::with(['meeting', 'scheduleMeeting.agenda.assignGoshwaraToAgenda.goshwara.department'])->find($id);

        $scheduleMeeting = ScheduleMeeting::where('id', $proceedingRecord->schedule_meeting_id)->first();

        $agenda = Agenda::where('id', $scheduleMeeting->agenda_id)->first();

        $scheduleMeetings = ScheduleMeeting::with(['meeting'])
            ->where('parent_id', $scheduleMeeting->parent_id)
            ->get();
        $ids = $scheduleMeetings->pluck('id')->toArray();

        $members = AssignMemberToMeeting::with(['member.attendance' => function ($q) use ($proceedingRecord) {
            return $q->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id);
        }])->where('meeting_id', $proceedingRecord->meeting_id)->get();

        $departmentAttendances = DepartmentAttendance::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id)
            ->where('meeting_id', $proceedingRecord->meeting_id)
            ->get();


        $departments = AssignScheduleMeetingDepartment::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id)
            ->get();

        $suplimentryAgendas = SuplimentryAgenda::whereIn('schedule_meeting_id', $ids)->get();

        $questions = Department::withWhereHas('questions', function ($q) use ($ids) {
            return $q->whereIn('schedule_meeting_id', $ids)->with(['subQuestions']);
        })->get();

        return view('proceeding-record.show')->with([
            'agenda' => $agenda,
            'scheduleMeetings' => $scheduleMeetings,
            'proceedingRecord' => $proceedingRecord,
            'members' => $members,
            'departments' => $departments,
            'suplimentryAgendas' => $suplimentryAgendas,
            'questions' => $questions,
            'departmentAttendances' => $departmentAttendances
        ]);
    }

    public function pdf($id)
    {
        $proceedingRecord = ProceedingRecord::with(['meeting', 'scheduleMeeting.agenda.assignGoshwaraToAgenda.goshwara.department'])->find($id);

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

        $questions = Department::withWhereHas('questions', function ($q) use ($ids) {
            return $q->whereIn('schedule_meeting_id', $ids)->with(['subQuestions']);
        })->get();

        $departmentAttendances = DepartmentAttendance::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->schedule_meeting_id)
            ->where('meeting_id', $proceedingRecord->meeting_id)
            ->get();

        $pdf = PDF::loadView('proceeding-record.pdf', [
            'agenda' => $agenda,
            'scheduleMeetings' => $scheduleMeetings,
            'proceedingRecord' => $proceedingRecord,
            'members' => $members,
            'departments' => $departments,
            'suplimentryAgendas' => $suplimentryAgendas,
            'questions' => $questions,
            'departmentAttendances' => $departmentAttendances
        ]);

        return $pdf->stream('document.pdf');

        // return view('proceeding-record.pdf')->with();
    }
}
