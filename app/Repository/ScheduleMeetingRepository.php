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
use App\Mail\ScheduleMeetingMail;
use Illuminate\Support\Facades\Mail;

class ScheduleMeetingRepository
{
    public function index()
    {
        $scheduleMeeting = ScheduleMeeting::with(['meeting', 'agenda'])->whereNull('schedule_meeting_id')->where('is_meeting_reschedule', 0)->where('is_meeting_completed', 0);

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

            // update parent_id
            ScheduleMeeting::where('id', $scheduleMeeting->id)->update(['parent_id' => $scheduleMeeting->id]);

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

            $scheduleMeeting = ScheduleMeeting::with(['agenda', 'meeting'])->where('id', $scheduleMeeting->id)->first();

            foreach ($members as $member) {
                Log::info('Sms Send to number' . $member->member->contact_number);
                Mail::to($member->member->email)->send(new ScheduleMeetingMail($scheduleMeeting));
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
        DB::beginTransaction();
        try {
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
            DB::rollback();
            return false;
        }
    }

    // function to show
    public function show($id)
    {
        return ScheduleMeeting::with(['meeting', 'agenda', 'assignScheduleMeetingDepartment.department'])->where('id', $id)->first();
    }

    public function cancel($request, $id)
    {
        DB::beginTransaction();
        try {
            $scheduleMeeting = ScheduleMeeting::find($id);
            $scheduleMeeting->is_meeting_cancel = 1;
            $scheduleMeeting->cancel_remark = $request->remark;
            $scheduleMeeting->cancel_meeting_date = date('Y-m-d');
            $scheduleMeeting->save();

            // logic to send sms and email
            $members = AssignMemberToMeeting::with(['member'])->where('meeting_id', $scheduleMeeting->meeting_id)->get();

            foreach ($members as $member) {
                Log::info('Meeting Cancel on date &  time ' . date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) . ' ' . $member->member->contact_number);
                Log::info('Meeting Cancel on date &  time ' . date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) . ' ' . $member->member->email);
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
}
