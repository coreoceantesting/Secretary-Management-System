<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\MeetingRepository;
use App\Http\Requests\Master\MeetingRequest;

class MeetingController extends Controller
{
    protected $meetingRepository;

    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function index()
    {
        $meetings = $this->meetingRepository->index();

        return view('master.meeting.meeting')->with([
            'meetings' => $meetings
        ]);
    }

    public function store(MeetingRequest $request)
    {
        $meeting = $this->meetingRepository->store($request);

        if ($meeting) {
            return response()->json(['success' => 'Meeting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $meeting = $this->meetingRepository->edit($id);

        if ($meeting) {
            $response = [
                'result' => 1,
                'meeting' => $meeting,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(MeetingRequest $request, $id)
    {
        $department = $this->meetingRepository->update($request, $id);

        if ($department) {
            return response()->json(['success' => 'Meeting updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $meeting = $this->meetingRepository->destroy($id);

        if ($meeting) {
            return response()->json(['success' => 'Meeting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}