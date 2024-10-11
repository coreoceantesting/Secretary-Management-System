<?php

namespace App\Repository\Master;

use App\Models\ElectionMeeting;
use App\Models\ElectionAssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ElectionMeetingRepository
{
    public function index()
    {
        return ElectionMeeting::select('id', 'name', 'head_person_name', 'head_person_designation')->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $electionMemberId = ElectionMeeting::create($request->all());

            $this->insertMember($request, $electionMemberId->id); // insert member to meeting

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return false;
        }
    }

    public function edit($id)
    {
        return ElectionMeeting::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $electionMeeting = ElectionMeeting::find($id);
            $electionMeeting->update($request->all());

            ElectionAssignMemberToMeeting::where('election_meeting_id', $id)->delete();
            $this->insertMember($request, $id); // insert member to meeting

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $electionMeeting = ElectionMeeting::find($id);
            $electionMeeting->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function insertMember($request, $meetingId)
    {
        $data = [];
        if (isset($request->member_id)) {
            if (count($request->member_id) > 0) {
                for ($i = 0; $i < count($request->member_id); $i++) {
                    $data = [
                        'election_meeting_id' => $meetingId,
                        'member_id' => $request->member_id[$i]
                    ];
                    ElectionAssignMemberToMeeting::create($data);
                }
            }
        }
    }

    public function assignMemberToMeeting($id)
    {
        return ElectionAssignMemberToMeeting::where('election_meeting_id', $id)->pluck('member_id', 'member_id')->all();
    }
}
