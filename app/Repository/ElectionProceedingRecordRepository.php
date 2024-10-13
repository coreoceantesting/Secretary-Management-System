<?php

namespace App\Repository;

use App\Models\ElectionProceedingRecord;
use App\Models\ElectionScheduleMeeting;
use App\Models\ElectionAssignMemberToMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProceedingRecordMail;

class ElectionProceedingRecordRepository
{
    public function index()
    {
        $proceddingRecords = ElectionProceedingRecord::with(['electionMeeting', 'electionScheduleMeeting'])
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->where('election_meeting_id', Auth::user()->meeting_id);
            })->latest()->get();

        return $proceddingRecords;
    }

    public function getScheduleMeeting($id)
    {
        return ElectionScheduleMeeting::where([
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 1,
            'is_meeting_cancel' => 0,
            'is_record_proceeding' => 0,
            'election_meeting_id' => $id
        ])->get();
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
            // Log::info('f');
            $proceedingRecord = ElectionProceedingRecord::create($request->all());

            ElectionScheduleMeeting::where('id', $request->election_schedule_meeting_id)->update([
                'is_record_proceeding' => 1
            ]);

            // logic to send sms and email
            $members = ElectionAssignMemberToMeeting::with(['member'])->where('election_meeting_id', $request->election_meeting_id)->get();

            $proceedingRecord = ElectionProceedingRecord::with(['electionMeeting'])->where('id', $proceedingRecord->id)->first();

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
