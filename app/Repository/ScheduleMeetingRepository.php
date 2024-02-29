<?php

namespace App\Repository;

use App\Models\ScheduleMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ScheduleMeetingRepository
{
    public function index()
    {
        return ScheduleMeeting::with(['meeting'])->get();
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
