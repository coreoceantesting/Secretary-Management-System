<?php

namespace App\Repository;

use App\Models\ProceedingRecord;
use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProceedingRecordRepository
{
    public function index()
    {
        $proceddingRecords = ProceedingRecord::with(['meeting', 'scheduleMeeting'])->get();

        return $proceddingRecords;
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where('meeting_id', $id)->where([
            'is_meeting_reschedule' => 0,
            'is_meeting_completed' => 1,
            'is_meeting_cancel' => 0,
            'is_record_proceeding' => 0
        ])->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $request['date'] = date('Y-m-d', strtotime($request->date));
            $request['time'] = date('h:i:s', strtotime($request->time));
            $request['datetime'] = date('Y-m-d', strtotime($request->date)) . " " . date('h:i:s', strtotime($request->time));

            $file = null;
            if ($request->hasFile('uploadfile')) {
                $file = $request->uploadfile->store('procedding-records');
            }
            $request['file'] = $file;
            ProceedingRecord::create($request->all());

            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_record_proceeding' => 1
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
