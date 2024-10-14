<?php

namespace App\Repository;

use App\Models\ElectionSuplimentryAgenda;
use App\Models\ElectionScheduleMeeting;
use App\Models\ElectionMeeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElectionSuplimentryAgendaRepository
{
    public function index()
    {
        return ElectionSuplimentryAgenda::with(['electionMeeting', 'electionScheduleMeeting'])
            ->whereHas('electionScheduleMeeting', function ($q) {
                $q->when(Auth::user()->hasRole('Clerk'), function ($query) {
                    return $query->where('election_meeting_id', Auth::user()->meeting_id);
                });
            })->latest()->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('agendafile')) {
                $file = $request->agendafile->store('election_suplimentry-agenda');
            }
            $request['file'] = $file;
            ElectionSuplimentryAgenda::create($request->all());

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
        return ElectionSuplimentryAgenda::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $agenda = ElectionSuplimentryAgenda::find($id);
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
            $agenda = ElectionSuplimentryAgenda::find($id);
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
        return ElectionMeeting::whereHas('electionScheduleMeeting', function ($q) {
            return $q->where(['is_meeting_completed' => 0, 'is_meeting_reschedule' => 0, 'is_meeting_cancel' => 0]);
        })->get();
    }

    public function getScheduleMeeting($id)
    {
        return ElectionScheduleMeeting::where(['is_meeting_completed' => 0, 'is_meeting_cancel' => 1, 'is_meeting_reschedule' => 0, 'election_meeting_id' => $id])->get();
    }
}
