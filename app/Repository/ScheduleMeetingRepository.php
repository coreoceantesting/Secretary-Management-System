<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\Agenda;
use App\Models\AssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ScheduleMeetingRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['meeting', 'agenda'])->where('is_meeting_reschedule', 0)->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $date = date('Y-m-d', strtotime($request->date));
            $time = date('h:i:s', strtotime($request->time));
            $file = null;
            if ($request->hasFile('agendafile')) {
                $file = $request->agendafile->store('schedulemeeting');
            }
            $request['file'] = $file;
            $request['date'] = $date;
            $request['time'] = $time;
            $request['datetime'] = $date . " " . $time;
            ScheduleMeeting::create($request->all());

            // change agenda schedule meeting status
            Agenda::where('id', $request->agenda_id)->update([
                'is_meeting_schedule' => 1
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
            Agenda::where('id', $scheduleMeeting->agenda_id)->update([
                'is_meeting_schedule' => 0
            ]);

            $file = $scheduleMeeting->file;
            if ($request->hasFile('agendafile')) {
                if ($scheduleMeeting->file != "") {
                    if (Storage::exists($scheduleMeeting->file)) {
                        Storage::delete($scheduleMeeting->file);
                    }
                }
                $file = $request->agendafile->store('schedulemeeting');
            }
            $request['file'] = $file;

            $date = date('Y-m-d', strtotime($request->date));
            $time = date('h:i:s', strtotime($request->time));
            $request['file'] = $file;
            $request['date'] = $date;
            $request['time'] = $time;
            $request['datetime'] = $date . " " . $time;
            $scheduleMeeting->update($request->all());

            // change agenda schedule meeting status
            Agenda::where('id', $request->agenda_id)->update([
                'is_meeting_schedule' => 1
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
            Agenda::where('id', $scheduleMeeting->agenda_id)->update([
                'is_meeting_schedule' => 0
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
