<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tharav;
use App\Models\ScheduleMeeting;

class TharavRepository
{
    public function index()
    {
        return Tharav::with(['meeting', 'scheduleMeeting'])->latest()->get();
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where('meeting_id', $id)->where([
            'is_record_proceeding' => 1
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
                $file = $request->uploadfile->store('tharav');
            }
            $request['file'] = $file;

            Tharav::create($request->all());

            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_tharav_uploaded' => 1
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }
}
