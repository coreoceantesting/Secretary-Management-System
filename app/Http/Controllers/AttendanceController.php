<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AttendanceRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\AttendanceRequest;
use App\Models\ScheduleMeeting;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $commonRepository;
    public function __construct(AttendanceRepository $attendanceRepository, CommonRepository $commonRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $attendances = $this->attendanceRepository->index();

        return view('attendance.index')->with([
            'attendances' => $attendances
        ]);
    }

    public function store(AttendanceRequest $request)
    {
        $attendances = $this->attendanceRepository->store($request);

        return redirect()->route('attendance.show', $request->schedule_meeting_id)->with('success', 'Attendance taken successfully');
    }

    public function show($id)
    {
        $attendance = $this->attendanceRepository->show($id);

        if ($attendance->is_meeting_completed) {
            return redirect()->route('attendance.index');
        }

        $members = $this->attendanceRepository->getMeetingMembers($attendance->meeting_id);
        // return $members;
        $attendanceMarks = $this->attendanceRepository->getPresentAttendence($id);

        $departmentAttendanceMarks = $this->attendanceRepository->getDepartmentPresentAttendence($id);

        $departments = $this->commonRepository->getDepartments();

        return view('attendance.show')->with([
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

            $attendance = $this->attendanceRepository->updateSingleMemberAttandance($request);

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

            $attendance = $this->attendanceRepository->saveDepartmentSingleMark($request);

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
                $attendance = $this->attendanceRepository->show($request->id);
                $members = $this->attendanceRepository->getMeetingMembers($attendance->meeting_id);

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
