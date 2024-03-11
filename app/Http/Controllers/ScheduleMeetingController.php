<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ScheduleMeetingRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\ScheduleMeetingRequest;

class ScheduleMeetingController extends Controller
{
    protected $scheduleMeetingRepository;
    protected $commonRepository;

    public function __construct(ScheduleMeetingRepository $scheduleMeetingRepository, CommonRepository $commonRepository)
    {
        $this->scheduleMeetingRepository = $scheduleMeetingRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $scheduleMeetings = $this->scheduleMeetingRepository->index();

        $meetings = $this->commonRepository->getMeeting();

        $agendas = $this->commonRepository->getNotScheduleMeetingAgenda();

        $departments = $this->commonRepository->getDepartments();

        return view('schedule-meeting.index')->with([
            'scheduleMeetings' => $scheduleMeetings,
            'meetings' => $meetings,
            'agendas' => $agendas,
            'departments' => $departments
        ]);
    }

    public function store(ScheduleMeetingRequest $request)
    {
        set_time_limit(0);

        $check = $this->commonRepository->checkMeetingExist($request);

        if ($check) {
            return response()->json(['error' => 'Meeting Already Exists on date ' . date('d-m-Y', strtotime($request->date))]);
        }

        $scheduleMeeting = $this->scheduleMeetingRepository->store($request);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $scheduleMeeting = $this->scheduleMeetingRepository->edit($id);

        $assignScheduleMeetingDepartments = $this->scheduleMeetingRepository->assignScheduleMeetingDepartments($id);

        $agendaHtml = '<option value="">--Select Agenda--</option>';
        $agendas = $this->commonRepository->getNotScheduleMeetingAgenda($scheduleMeeting->agenda_id);

        foreach ($agendas as $agenda) :
            $isSelected = $agenda->id == $scheduleMeeting->agenda_id ? 'selected' : '';
            $agendaHtml .= '<option value="' . $agenda->id . '" ' . $isSelected . '>' . $agenda->name . '</option>';
        endforeach;

        if ($scheduleMeeting) {
            $response = [
                'result' => 1,
                'scheduleMeeting' => $scheduleMeeting,
                'agendaHtml' => $agendaHtml,
                'assignScheduleMeetingDepartments' => $assignScheduleMeetingDepartments
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(ScheduleMeetingRequest $request, $id)
    {
        $check = $this->commonRepository->checkEditMeetingExist($request, $id);

        if ($check) {
            return response()->json(['error' => 'Meeting Already Exists on date ' . date('d-m-Y', strtotime($request->date))]);
        }

        $scheduleMeeting = $this->scheduleMeetingRepository->update($request, $id);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $scheduleMeeting = $this->scheduleMeetingRepository->destroy($id);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function show($id)
    {
        $scheduleMeeting = $this->scheduleMeetingRepository->show($id);

        return view('schedule-meeting.show')->with(['scheduleMeeting' => $scheduleMeeting]);
    }

    public function cancel(Request $request, $id)
    {
        $scheduleMeeting = $this->scheduleMeetingRepository->cancel($request, $id);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting cancel successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
