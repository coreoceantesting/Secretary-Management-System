<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ElectionAttendanceRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\AttendanceRequest;
use App\Models\ScheduleMeeting;

class ElectionAttendanceController extends Controller
{
    protected $electionAttendanceRepository;
    protected $commonRepository;
    public function __construct(ElectionAttendanceRepository $electionAttendanceRepository, CommonRepository $commonRepository)
    {
        $this->electionAttendanceRepository = $electionAttendanceRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $attendances = $this->electionAttendanceRepository->index();

        return view('election.attendance.index')->with([
            'attendances' => $attendances
        ]);
    }

    public function store(AttendanceRequest $request)
    {
        // dd($request->all());
        $attendance = $this->electionAttendanceRepository->store($request);

        if ($attendance) {
            return redirect()->route('election.attendance.show', $request->election_schedule_meeting_id)->with('success', 'Election attendance taken successfully');
        }
    }

    public function show($id)
    {
        $attendance = $this->electionAttendanceRepository->show($id);

        if ($attendance->is_meeting_completed) {
            // dd('ff');
            return redirect()->route('election.attendance.index');
        }

        $members = $this->electionAttendanceRepository->getMeetingMembers($attendance->election_meeting_id);
        // return $members;
        $attendanceMarks = $this->electionAttendanceRepository->getPresentAttendence($id);

        $departmentAttendanceMarks = $this->electionAttendanceRepository->getDepartmentPresentAttendence($id);

        $departments = $this->commonRepository->getDepartments();

        return view('election.attendance.show')->with([
            'attendance' => $attendance,
            'members' => $members,
            'attendanceMarks' => $attendanceMarks,
            'departmentAttendanceMarks' => $departmentAttendanceMarks,
            'departments' => $departments,
        ]);
    }

    public function saveSingleMark(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $attendance = $this->electionAttendanceRepository->updateSingleMemberAttandance($request);

            if ($attendance) {
                return response()->json(['success' => 'Attendance updated successfully!', 'id' => $request->id]);
            } else {
                return response()->json(['error' => 'Something went wrong please try again', 'id' => $request->id]);
            }
        }
    }

    public function saveDepartmentSingleMark(Request $request)
    {
        if ($request->ajax()) {
            $attendance = $this->electionAttendanceRepository->saveDepartmentSingleMark($request);

            if ($attendance) {
                return response()->json(['success' => 'Attendance updated successfully!', 'id' => $request->id, 'departmentAttenceId' => $attendance[1]]);
            } else {
                return response()->json(['error' => 'Something went wrong please try again', 'id' => $request->id]);
            }
        }
    }

    public function startMeetingSendSms(Request $request)
    {
        if ($request->ajax()) {

            if ($request->name == "start") {
                $attendance = $this->electionAttendanceRepository->show($request->id);
                $members = $this->electionAttendanceRepository->getMeetingMembers($attendance->meeting_id);

                foreach ($members as $member) {
                    \Log::info('SMS Send to No. ' . $member?->member?->contact_number);
                }

                ScheduleMeeting::where('id', $request->id)->update([
                    'is_sms_send' => 1,
                    'sms_send_time' => now()
                ]);

                return response()->json([
                    'success' => 'Sms send successfully'
                ]);
            } elseif ($request->name == "pause") {
                ScheduleMeeting::where('id', $request->id)->update([
                    'is_sms_send' => 0,
                    'sms_send_time' => now()
                ]);

                return response()->json([
                    'success' => 'Sms send successfully'
                ]);
            } else {
                return response()->json(['error' => 'Something went wrong please try again', 'id' => $request->id]);
            }
        }
    }
}
