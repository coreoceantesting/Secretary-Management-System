<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ElectionProceedingRecordRepository;
use App\Repository\CommonRepository;
use App\Models\ElectionAgenda;
use App\Models\Department;
use App\Models\ElectionAssignMemberToMeeting;
use App\Models\ElectionDepartmentAttendance;
use App\Models\ElectionMeeting;
use App\Models\ElectionScheduleMeeting;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\ElectionProceedingRecord;
use App\Http\Requests\ElectionProceedingRecordRequest;
use PDF;

class ElectionProceedingRecordController extends Controller
{
    protected $electionProceedingRecordRepository;
    protected $commonRepository;

    public function __construct(ElectionProceedingRecordRepository $electionProceedingRecordRepository, CommonRepository $commonRepository)
    {
        $this->electionProceedingRecordRepository = $electionProceedingRecordRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $proceedingRecords = $this->electionProceedingRecordRepository->index();

        $meetings = ElectionMeeting::whereHas('electionScheduleMeeting', function ($q) {
            return $q->where('is_meeting_completed', 1)->where('is_record_proceeding', 0);
        })->get();

        return view('election.proceeding-record.index')->with([
            'proceedingRecords' => $proceedingRecords,
            'meetings' => $meetings
        ]);
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {

            $electionScheduleMeetings = $this->electionProceedingRecordRepository->getScheduleMeeting($id);

            $results = $electionScheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  $item['unique_id'] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'results' => $results
            ]);
        }
    }

    public function store(ElectionProceedingRecordRequest $request)
    {
        $proceedingRecord = $this->electionProceedingRecordRepository->store($request);

        if ($proceedingRecord) {
            return response()->json(['success' => 'Election Proceeding Record created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function show($id)
    {
        $proceedingRecord = ElectionProceedingRecord::with(['electionMeeting', 'electionScheduleMeeting.electionAgenda'])->find($id);

        $scheduleMeeting = ElectionScheduleMeeting::where('id', $proceedingRecord->election_schedule_meeting_id)->first();

        $agenda = ElectionAgenda::where('id', $scheduleMeeting->election_agenda_id)->first();

        $scheduleMeetings = ElectionScheduleMeeting::with(['electionMeeting'])
            ->where('parent_id', $scheduleMeeting->parent_id)
            ->get();
        $ids = $scheduleMeetings->pluck('id')->toArray();

        $members = ElectionAssignMemberToMeeting::with(['member.electionAttendance' => function ($q) use ($proceedingRecord) {
            return $q->where('election_schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id);
        }])->where('election_meeting_id', $proceedingRecord->election_meeting_id)->get();

        $departmentAttendances = ElectionDepartmentAttendance::where('schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id)
            ->where('election_meeting_id', $proceedingRecord->election_meeting_id)
            ->get();


        $departments = AssignScheduleMeetingDepartment::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id)
            ->get();


        return view('election.proceeding-record.show')->with([
            'agenda' => $agenda,
            'scheduleMeetings' => $scheduleMeetings,
            'proceedingRecord' => $proceedingRecord,
            'members' => $members,
            'departments' => $departments,
            'departmentAttendances' => $departmentAttendances,
        ]);
    }

    public function pdf($id)
    {

        $proceedingRecord = ElectionProceedingRecord::with(['electionMeeting', 'electionScheduleMeeting.electionAgenda'])->find($id);

        $scheduleMeeting = ElectionScheduleMeeting::where('id', $proceedingRecord->election_schedule_meeting_id)->first();
        // return $proceedingRecord;
        $agenda = ElectionAgenda::where('id', $scheduleMeeting->election_agenda_id)->first();

        $scheduleMeetings = ElectionScheduleMeeting::with(['electionMeeting'])
            ->where('parent_id', $scheduleMeeting->parent_id)
            ->get();
        $ids = $scheduleMeetings->pluck('id')->toArray();

        $members = ElectionAssignMemberToMeeting::with(['member.electionAttendance' => function ($q) use ($proceedingRecord) {
            return $q->where('election_schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id);
        }])->where('election_meeting_id', $proceedingRecord->election_meeting_id)->get();

        $departmentAttendances = ElectionDepartmentAttendance::where('schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id)
            ->where('election_meeting_id', $proceedingRecord->election_meeting_id)
            ->get();


        $departments = AssignScheduleMeetingDepartment::with(['department'])
            ->where('schedule_meeting_id', $proceedingRecord->election_schedule_meeting_id)
            ->get();

        $pdf = PDF::loadView('election.proceeding-record.pdf', [
            'agenda' => $agenda,
            'scheduleMeetings' => $scheduleMeetings,
            'proceedingRecord' => $proceedingRecord,
            'members' => $members,
            'departments' => $departments,
            'departmentAttendances' => $departmentAttendances,
        ]);

        return $pdf->stream('document.pdf');

        // return view('proceeding-record.pdf')->with();
    }
}
