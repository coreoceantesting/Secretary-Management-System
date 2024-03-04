<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\AssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RescheduleMeetingRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['meeting', 'agenda'])
            ->whereNotNull('schedule_meeting_id')
            ->latest()
            ->get();
    }

    public function getScheduleMeeting($meetingId)
    {
        return ScheduleMeeting::where(['meeting_id' => $meetingId, 'is_meeting_reschedule' => 0, 'is_meeting_completed' => 0])
            ->whereDate('date', '>', date('Y-m-d', strtotime('+7 days')))->select('id', 'datetime')->get();
    }

    public function getEditScheduleMeeting($meetingId, $scheduleMeetingId, $id)
    {
        return ScheduleMeeting::where(['meeting_id' => $meetingId, 'is_meeting_completed' => 0])
            ->where('id', '!=', $id)
            ->where(function ($q) use ($scheduleMeetingId) {
                return $q->where('is_meeting_reschedule', 0)->orWhere('id', $scheduleMeetingId);
            })
            ->whereDate('date', '>', date('Y-m-d', strtotime('+7 days')))
            ->select('id', 'datetime')
            ->get();
    }

    public function getScheduleMeetingDetails($scheduleMeetingId)
    {
        return ScheduleMeeting::with(['meeting', 'agenda'])->where('id', $scheduleMeetingId)->first();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $meeting = ScheduleMeeting::find($request->schedule_meeting_id);

            $date = date('Y-m-d', strtotime($request->date));
            $time = date('h:i:s', strtotime($request->time));
            $request['agenda_id'] = $meeting->agenda_id;
            $request['file'] = $meeting->file;
            $request['date'] = $date;
            $request['time'] = $time;
            $request['datetime'] = $date . " " . $time;
            ScheduleMeeting::create($request->all());


            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_meeting_reschedule' => 1
            ]);

            // logic to send sms and email
            $members = AssignMemberToMeeting::with(['member'])->where('meeting_id', $request->meeting_id)->get();

            foreach ($members as $member) {
                Log::info('Sms Send to number' . $member->member->contact_number);
                Log::info('email Send to id' . $member->member->email);
            }
            // end of send sms and email login


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
        return ScheduleMeeting::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $scheduleMeeting = ScheduleMeeting::find($id);
            // change agenda schedule meeting status
            ScheduleMeeting::where('id', $scheduleMeeting->schedule_meeting_id)->update([
                'is_meeting_reschedule' => 0
            ]);

            $date = date('Y-m-d', strtotime($request->date));
            $time = date('h:i:s', strtotime($request->time));
            $request['file'] = $scheduleMeeting->file;
            $request['date'] = $date;
            $request['time'] = $time;
            $request['datetime'] = $date . " " . $time;
            $scheduleMeeting->update($request->all());

            // change agenda schedule meeting status
            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_meeting_reschedule' => 1
            ]);

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
            $scheduleMeeting = ScheduleMeeting::find($id);
            // change agenda schedule meeting status
            ScheduleMeeting::where('id', $scheduleMeeting->schedule_meeting_id)->update([
                'is_meeting_reschedule' => 0
            ]);


            if ($scheduleMeeting->file != "") {
                if (Storage::exists($scheduleMeeting->file)) {
                    Storage::delete($scheduleMeeting->file);
                }
            }

            $scheduleMeeting->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
