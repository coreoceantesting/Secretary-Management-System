<?php

namespace App\Repository;

use App\Models\ProceedingRecord;
use App\Models\ScheduleMeeting;
use App\Models\AssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProceedingRecordMail;
use App\Models\UserMeeting;

class ProceedingRecordRepository
{
    public function index()
    {
        $proceddingRecords = ProceedingRecord::with(['meeting', 'scheduleMeeting'])
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->whereIn('meeting_id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
            })->latest()->get();

        return $proceddingRecords;
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where('meeting_id', $id)->where([
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 1,
            'is_meeting_cancel' => 0,
            'is_record_proceeding' => 0
        ])->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->whereIn('meeting_id', UserMeeting::where('user_id', Auth::user()->id)->pluck('meeting_id')->toArray());
        })->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $request['date'] = date('Y-m-d', strtotime($request->date));
            $request['time'] = date('H:i:s', strtotime($request->time));
            $request['datetime'] = date('Y-m-d', strtotime($request->date)) . " " . date('H:i:s', strtotime($request->time));

            $file = null;
            if ($request->hasFile('uploadfile')) {
                $file = $request->uploadfile->store('procedding-records');
            }
            $request['file'] = $file;
            $proceedingRecord = ProceedingRecord::create($request->all());

            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_record_proceeding' => 1
            ]);


            // logic to send sms and email
            $members = AssignMemberToMeeting::with(['member'])->where('meeting_id', $request->meeting_id)->get();

            $proceedingRecord = ProceedingRecord::with(['meeting'])->where('id', $proceedingRecord->id)->first();

            foreach ($members as $member) {
                Log::info('Sms Send to number' . $member->member->contact_number);
                Mail::to($member->member->email)->send(new ProceedingRecordMail($proceedingRecord));
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
