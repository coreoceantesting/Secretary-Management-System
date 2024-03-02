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

    public function store()
    {
    }

    public function show()
    {
    }
}
