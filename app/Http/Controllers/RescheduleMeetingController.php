<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\RescheduleMeetingRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\RescheduleMeetingRequest;

class RescheduleMeetingController extends Controller
{
    protected $rescheduleMeetingRepository;
    protected $commonRepository;

    public function __construct(RescheduleMeetingRepository $rescheduleMeetingRepository, CommonRepository $commonRepository)
    {
        $this->rescheduleMeetingRepository = $rescheduleMeetingRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $rescheduleMeetings = $this->rescheduleMeetingRepository->index();

        $meetings = $this->commonRepository->getMeeting();

        return view('reschedule-meeting.index')->with([
            'rescheduleMeetings' => $rescheduleMeetings,
            'meetings' => $meetings
        ]);
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $rescheduleMeetings = $this->rescheduleMeetingRepository->getScheduleMeeting($id);

            $results = $rescheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  date('d-m-Y h:i A', strtotime($item["datetime"]));
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'status' => 200,
                'data' => $results
            ]);
        }
    }

    public function getScheduleMeetingDetails(Request $request, $id)
    {
        if ($request->ajax()) {
            $rescheduleMeeting = $this->rescheduleMeetingRepository->getScheduleMeetingDetails($id);

            $result = [
                'agenda' => $rescheduleMeeting->agenda?->name,
                'meeting' => $rescheduleMeeting->meeting?->name,
                'date' => date('d-m-Y', strtotime($rescheduleMeeting->date)),
                'time' => date('h:i A', strtotime($rescheduleMeeting->time)),
                'place' => $rescheduleMeeting->place,
            ];

            // to get department
            $departmentHtml = "";
            $value = "";
            $departments = $this->rescheduleMeetingRepository->assignScheduleMeetingDepartments($id);
            // $departments = $this->commonRepository->getDepartments();
            foreach ($departments as $department) {

                $departmentHtml .= '<input type="hidden" name="department_id[]" value="' . $department->department_id . '" />';
                $value .= $department->department->name . ", ";
            }
            $departmentHtml .= '<input type="text" value="' . $value . '" class="form-control" readonly />';

            return response()->json([
                'status' => 200,
                'data' => $result,
                'departments' => $departmentHtml
            ]);
        }
    }

    public function store(RescheduleMeetingRequest $request)
    {
        $check = $this->commonRepository->checkMeetingExist($request);

        if ($check) {
            return response()->json(['error' => 'Meeting Already Exists on date ' . date('d-m-Y', strtotime($request->date))]);
        }

        $rescheduleMeeting = $this->rescheduleMeetingRepository->store($request);

        if ($rescheduleMeeting) {
            return response()->json(['success' => 'Reschedule meeting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $scheduleMeeting = $this->rescheduleMeetingRepository->edit($id);

        $rescheduleMeetings = $this->rescheduleMeetingRepository->getEditScheduleMeeting($scheduleMeeting->meeting_id, $scheduleMeeting->schedule_meeting_id, $scheduleMeeting->id);

        $scheduleMeetingDateTime = '<label class="col-form-label" for="schedule_meeting_id">
                Select Schedule Meeting Date
                <span class="text-danger">*</span>
            </label>
            <select class="form-select col-sm-12 selectChnageScheduleMeetingDetails" id="schedule_meeting_id" name="schedule_meeting_id">
                <option value="">--Select Schedule Meeting--</option>';

        foreach ($rescheduleMeetings as $rescheduleMeeting) :
            $isSelected = $rescheduleMeeting->id == $scheduleMeeting->schedule_meeting_id ? 'selected' : '';
            $scheduleMeetingDateTime .= '<option value="' . $rescheduleMeeting->id . '" ' . $isSelected . '>' . date('d-m-Y h:i A', strtotime($rescheduleMeeting->datetime)) . '</option>';
        endforeach;
        $scheduleMeetingDateTime .= '</select>';

        // get re schedule meeting datetime detail
        $rescheduleMeeting = $this->rescheduleMeetingRepository->getScheduleMeetingDetails($id);
        $mettingDetails = '<table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th colspan="5">Old Meeting Details</th>
                                </tr>
                                <tr>
                                    <th>Agenda</th>
                                    <th>Meeting</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Place</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>' . $rescheduleMeeting->agenda?->name . '</td>
                                    <td>' . $rescheduleMeeting->meeting?->name . '</td>
                                    <td>' . date('d-m-Y', strtotime($rescheduleMeeting->date)) . '</td>
                                    <td>' . date('h:i A', strtotime($rescheduleMeeting->time)) . '</td>
                                    <td>' . $rescheduleMeeting->place . '</td>
                                </tr>
                            </tbody>
                        </table>';

        if ($scheduleMeeting) {
            $response = [
                'result' => 1,
                'scheduleMeeting' => $scheduleMeeting,
                'scheduleMeetingDateTime' => $scheduleMeetingDateTime,
                'mettingDetails' => $mettingDetails
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(RescheduleMeetingRequest $request, $id)
    {
        $check = $this->commonRepository->checkEditMeetingExist($request, $id);

        if ($check) {
            return response()->json(['error' => 'Meeting Already Exists on date ' . date('d-m-Y', strtotime($request->date))]);
        }

        $scheduleMeeting = $this->rescheduleMeetingRepository->update($request, $id);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function show($id)
    {
        $rescheduleMeeting = $this->rescheduleMeetingRepository->show($id);

        return view('reschedule-meeting.show')->with(['rescheduleMeeting' => $rescheduleMeeting]);
    }

    public function destroy($id)
    {
        $scheduleMeeting = $this->rescheduleMeetingRepository->destroy($id);

        if ($scheduleMeeting) {
            return response()->json(['success' => 'Schedule meeting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
