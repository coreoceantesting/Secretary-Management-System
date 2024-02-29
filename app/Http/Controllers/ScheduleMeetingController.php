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

        return view('schedule-meeting.index')->with([
            'scheduleMeetings' => $scheduleMeetings,
            'meetings' => $meetings,
        ]);
    }

    public function store(ScheduleMeetingRequest $request)
    {
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

        if ($scheduleMeeting) {
            $response = [
                'result' => 1,
                'scheduleMeeting' => $scheduleMeeting,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(ScheduleMeetingRequest $request, $id)
    {
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
}
