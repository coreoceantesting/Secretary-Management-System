<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AttendanceRepository;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        $attendances = $this->attendanceRepository->index();

        return view('attendance.index')->with([
            'attendances' => $attendances
        ]);
    }

    public function store(Request $request)
    {
        $attendances = $this->attendanceRepository->store($request);

        return redirect()->route('attendance.index')->with('success', 'Attendance taken successfully');
    }

    public function show($id)
    {
        $attendance = $this->attendanceRepository->show($id);

        if ($attendance->is_record_proceeding) {
            return redirect()->route('attendance.index');
        }

        $members = $this->attendanceRepository->getMeetingMembers($attendance->meeting_id);

        $attendanceMarks = $this->attendanceRepository->getPresentAttendence($id);

        return view('attendance.show')->with([
            'attendance' => $attendance,
            'members' => $members,
            'attendanceMarks' => $attendanceMarks
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
}
