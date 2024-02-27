<?php

namespace App\Repository\Master;

use App\Models\Meeting;
use App\Models\AssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeetingRepository
{
    public function index()
    {
        $meetings = Meeting::select('id', 'name', 'head_person_name', 'head_person_designation')->get();

        return $meetings;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $memberId = Meeting::create($request->all());

            $this->insertMember($request, $memberId->id); // insert member to meeting

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
        $meeting = Meeting::find($id);

        return $meeting;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $meeting = Meeting::find($id);
            $meeting->update($request->all());

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
            $meeting = Meeting::find($id);
            $meeting->delete();
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
                        'meeting_id' => $meetingId,
                        'member_id' => $request->member_id[$i]
                    ];
                    AssignMemberToMeeting::create($data);
                }
            }
        }
    }

    public function assignMemberToMeeting($id)
    {
        return AssignMemberToMeeting::where('meeting_id', $id)->pluck('member_id', 'member_id')->all();
    }
}
