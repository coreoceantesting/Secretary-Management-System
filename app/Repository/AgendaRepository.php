<?php

namespace App\Repository;

use App\Models\Agenda;
use App\Models\Goshwara;
use App\Models\AssignGoshwaraToAgenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Meeting;
use PDF;

class AgendaRepository
{
    public function index()
    {
        return Agenda::with(['assignGoshwaraToAgenda.goshwara'])
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->where('meeting_id', Auth::user()->meeting_id);
            })
            ->latest()->get();
    }

    public function getNotAssignedGoshwara()
    {
        return Goshwara::doesntHave('assignGoshwaraToAgenda')->where([
            'is_sent' => 1,
        ])->with('meeting')->get();
    }

    public function getAddNotAssignedGoshwara($meetingId)
    {
        return Goshwara::with('meeting')->doesntHave('assignGoshwaraToAgenda')->where([
            'is_sent' => 1,
            'meeting_id' => $meetingId
        ])->get();
    }

    public function getMeetings()
    {
        return Meeting::whereHas('goshwara', function ($q) {
            return $q->where([
                'is_sent' => 1,
                'is_mayor_selected' => 0,
            ]);
        })->when(Auth::user()->roles[0]->name == "Clerk", function ($q) {
            return $q->where("meeting_id", Auth::user()->meeting_id);
        })->latest()->get();
    }

    public function getAssignedGoshwaraById($id, $meetingId)
    {
        return Goshwara::orWhereHas('assignGoshwaraToAgenda', function ($q) use ($id) {
            return $q->where('agenda_id', $id);
        })->with('meeting')->where('meeting_id', $meetingId)->where('is_sent', 1)->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('agendafile')) {
                $file = $request->agendafile->store('agenda');
            }
            $request['file'] = $file;
            $agenda = Agenda::create($request->all());

            if (isset($request->goshwara_id)) {
                for ($i = 0; $i < count($request->goshwara_id); $i++) {
                    AssignGoshwaraToAgenda::create([
                        'agenda_id' => $agenda->id,
                        'goshwara_id' => $request->goshwara_id[$i],
                    ]);
                }

                // code to generate pdf
                $goshwaras = AssignGoshwaraToAgenda::with(['goshwara'])
                    ->where('goshwara_id', $agenda->id)->get();
                $pdf = PDF::loadView('agenda.pdf', compact('agenda', 'goshwaras'));
                $name = 'pdf/' . 'agenda-' . time() . '.pdf';

                Storage::put($name, $pdf->output());

                Agenda::where('id', $agenda->id)->update([
                    'pdf' => $name
                ]);
                // end of code to generate pdf
            }

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
        return Agenda::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $agenda = Agenda::find($id);
            $file = $agenda->file;
            if ($request->hasFile('agendafile')) {
                if ($agenda->file != "") {
                    if (Storage::exists($agenda->file)) {
                        Storage::delete($agenda->file);
                    }
                }
                $file = $request->agendafile->store('agenda');
            }
            $request['file'] = $file;
            $agenda->update($request->all());

            if (isset($request->goshwara_id)) {
                Goshwara::whereHas('assignGoshwaraToAgenda', function ($q) use ($id) {
                    $q->where('agenda_id', $id);
                })->update([
                    'is_mayor_selected' => 0,
                    'selected_datetime' => null,
                    'selected_by' => null
                ]);

                AssignGoshwaraToAgenda::where('agenda_id', $id)->delete();
                for ($i = 0; $i < count($request->goshwara_id); $i++) {
                    AssignGoshwaraToAgenda::create([
                        'agenda_id' => $id,
                        'goshwara_id' => $request->goshwara_id[$i],
                    ]);

                    if (Auth::user()->roles[0]->name == "Mayor") {
                        Goshwara::where('id', $request->goshwara_id[$i])->update([
                            'is_mayor_selected' => 1,
                            'selected_datetime' => date('Y-m-d h:i:s'),
                            'selected_by' => Auth::user()->id
                        ]);
                    }
                }

                // code to generate pdf
                $goshwaras = AssignGoshwaraToAgenda::with(['goshwara'])
                    ->where('goshwara_id', $agenda->id)->get();
                $pdf = PDF::loadView('agenda.pdf', compact('agenda', 'goshwaras'));
                $name = 'pdf/' . $agenda->file . '.pdf';

                Storage::put($name, $pdf->output());

                Agenda::where('id', $agenda->id)->update([
                    'pdf' => $name
                ]);
                // end of code to generate pdf
            }

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

            AssignGoshwaraToAgenda::where('agenda_id', $id)->delete();
            $agenda = Agenda::find($id);
            if ($agenda->file != "") {
                if (Storage::exists($agenda->file)) {
                    Storage::delete($agenda->file);
                }

                if (Storage::exists($agenda->pdf)) {
                    Storage::delete($agenda->pdf);
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
}
