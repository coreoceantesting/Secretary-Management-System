<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectionAgenda;
use App\Models\ElectionMeeting;
use Illuminate\Support\Facades\Storage;

class ElectionAgendaController extends Controller
{
    public function index()
    {
        $meetings = ElectionMeeting::all();

        $electionAgendas = ElectionAgenda::with(['meeting'])->get();

        return view('election.agenda.index')->with([
            'electionAgendas' => $electionAgendas,
            'meetings' => $meetings
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {

                if ($request->hasFile('agendafile')) {
                    $request['file'] = $request->agendafile->store('election/agenda');
                }
                ElectionAgenda::create($request->all());
                return response()->json([
                    'success' => 'Election agenda created successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $electionAgenda = ElectionAgenda::find($id);

            return response()->json([
                'electionAgenda' => $electionAgenda
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $electionAgenda = ElectionAgenda::find($id);
                if ($request->hasFile('agendafile')) {
                    if ($electionAgenda->file != "") {
                        if (Storage::exists($electionAgenda->file)) {
                            Storage::delete($electionAgenda->file);
                        }
                    }
                    $request['file'] = $request->agendafile->store('election/agenda');
                }
                $electionAgenda->update($request->all());

                return response()->json([
                    'success' => 'Election agenda updated successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $electionAgenda = ElectionAgenda::find($id);
                $electionAgenda->delete();

                return response()->json([
                    'success' => 'Election agenda updated successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }
}
