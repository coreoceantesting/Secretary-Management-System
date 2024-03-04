<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use App\Models\Agenda;
use App\Models\AssignMemberToMeeting;
use App\Models\AssignScheduleMeetingDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleMeetingRepository
{
    public function index()
    {
        $scheduleMeeting = ScheduleMeeting::with(['meeting', 'agenda'])->whereNull('schedule_meeting_id');

        if (Auth::user()->hasRole('Department')) {
            $scheduleMeeting = $scheduleMeeting->whereHas('assignScheduleMeetingDepartment', function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            });
        }
        $scheduleMeeting = $scheduleMeeting->latest()->get();

        return $scheduleMeeting;
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
            $scheduleMeeting = ScheduleMeeting::create($request->all());

            // logic to assign schedule meeting to department
            if (isset($request->department_id)) {
                for ($i = 0; $i < count($request->department_id); $i++) {
                    $assignScheduleMeetingDepartment = new AssignScheduleMeetingDepartment;
                    $assignScheduleMeetingDepartment->schedule_meeting_id = $scheduleMeeting->id;
                    $assignScheduleMeetingDepartment->department_id = $request->department_id[$i];
                    $assignScheduleMeetingDepartment->save();
                }
            }
            // end of logic to assign schedule meeting to department

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

    public function assignScheduleMeetingDepartments($id)
    {
        return AssignScheduleMeetingDepartment::where('schedule_meeting_id', $id)->pluck('department_id');
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

            // logic to assign schedule meeting to department
            if (isset($request->department_id)) {
                AssignScheduleMeetingDepartment::where('schedule_meeting_id', $id)->delete();

                for ($i = 0; $i < count($request->department_id); $i++) {
                    $assignScheduleMeetingDepartment = new AssignScheduleMeetingDepartment;
                    $assignScheduleMeetingDepartment->schedule_meeting_id = $scheduleMeeting->id;
                    $assignScheduleMeetingDepartment->department_id = $request->department_id[$i];
                    $assignScheduleMeetingDepartment->save();
                }
            }
            // end of logic to assign schedule meeting to department

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

            AssignScheduleMeetingDepartment::where('schedule_meeting_id', $id)->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    // function to show
    public function show($id)
    {
        return ScheduleMeeting::with(['meeting', 'agenda'])->where('id', $id)->first();
    }
}
