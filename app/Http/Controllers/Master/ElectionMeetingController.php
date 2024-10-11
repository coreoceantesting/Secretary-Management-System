<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\ElectionMeetingRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\Master\MeetingRequest;

class ElectionMeetingController extends Controller
{
    protected $electionMeetingRepository;
    protected $commonRepository;

    public function __construct(ElectionMeetingRepository $electionMeetingRepository, CommonRepository $commonRepository)
    {
        $this->electionMeetingRepository = $electionMeetingRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $electionMeetings = $this->electionMeetingRepository->index();

        $wardMembers = $this->commonRepository->getWardMember();

        return view('master.election-meeting.index')->with([
            'electionMeetings' => $electionMeetings,
            'wardMembers' => $wardMembers
        ]);
    }

    // function to store meeting
    public function store(MeetingRequest $request)
    {
        $meeting = $this->electionMeetingRepository->store($request);

        if ($meeting) {
            return response()->json(['success' => 'Election meeting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to edit the meeting by id
    public function edit($id)
    {
        $meeting = $this->electionMeetingRepository->edit($id);

        $wardMembers = $this->commonRepository->getWardMember();

        $assignMemberToMeeting = $this->electionMeetingRepository->assignMemberToMeeting($id);

        $memberHtml = "";
        foreach ($wardMembers as $wardMember) {
            $memberHtml .= '<span class="text-danger is-invalid member_id_err"></span><div class="form-group m-t-15 row roles-checkbox-group">
                                    <strong class="mt-2"> ' . $wardMember->name . '</strong>';
            foreach ($wardMember?->members as $member) {
                $checked = "";
                if (in_array($member->id, $assignMemberToMeeting)) {
                    $checked = "checked";
                }
                $memberHtml .= '<div class="col-3 py-2 form-check">
                                        <label class="d-block form-check-label" for="chk-ani' . str_replace(' ', '-', $member->name) . '">
                                            <input class="checkbox_animated form-check-input" ' . $checked . '  id="chk-ani' . str_replace(' ', '-', $member->name) . '" type="checkbox" name="member_id[]" value="' . $member->id . '">' . $member->name . '
                                        </label>
                                    </div>';
            }
            $memberHtml .= '</div>';
        }

        if ($meeting) {
            $response = [
                'result' => 1,
                'meeting' => $meeting,
                'memberHtml' => $memberHtml
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    // function to update the meeting
    public function update(MeetingRequest $request, $id)
    {
        $department = $this->electionMeetingRepository->update($request, $id);

        if ($department) {
            return response()->json(['success' => 'Election meeting updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to delete the meeting
    public function destroy($id)
    {
        $meeting = $this->electionMeetingRepository->destroy($id);

        if ($meeting) {
            return response()->json(['success' => 'Election meeting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
