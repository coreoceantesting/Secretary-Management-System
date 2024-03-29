<?php

namespace App\Repository;

use App\Models\SuplimentryAgenda;
use App\Models\ScheduleMeeting;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SuplimentryAgendaRepository
{
    public function index()
    {
        return SuplimentryAgenda::with(['meeting', 'scheduleMeeting'])->latest()->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('agendafile')) {
                $file = $request->agendafile->store('suplimentry-agenda');
            }
            $request['file'] = $file;
            SuplimentryAgenda::create($request->all());

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
        return SuplimentryAgenda::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $agenda = SuplimentryAgenda::find($id);
            $file = $agenda->file;
            if ($request->hasFile('agendafile')) {
                if ($agenda->file != "") {
                    if (Storage::exists($agenda->file)) {
                        Storage::delete($agenda->file);
                    }
                }
                $file = $request->agendafile->store('suplimentry-agenda');
            }
            $request['file'] = $file;
            $agenda->update($request->all());

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
            $agenda = SuplimentryAgenda::find($id);
            if ($agenda->file != "") {
                if (Storage::exists($agenda->file)) {
                    Storage::delete($agenda->file);
                }
            }

            $agenda->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function getMeetings()
    {
        return Meeting::whereHas('scheduleMeeting', function ($q) {
            return $q->where(['is_meeting_completed' => 0, 'is_meeting_reschedule' => 0]);
        })->get();
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where(['is_meeting_completed' => 0, 'is_meeting_reschedule' => 0, 'meeting_id' => $id])->get();
    }
}
