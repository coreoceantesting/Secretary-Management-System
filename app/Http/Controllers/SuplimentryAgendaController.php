<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SuplimentryAgendaRepository;
use App\Http\Requests\SuplimentryAgendaRequest;

class SuplimentryAgendaController extends Controller
{
    protected $suplimentryAgendaRepository;

    public function __construct(SuplimentryAgendaRepository $suplimentryAgendaRepository)
    {
        $this->suplimentryAgendaRepository = $suplimentryAgendaRepository;
    }

    public function index()
    {
        $suplimentryAgendas = $this->suplimentryAgendaRepository->index();

        $scheduleMeetings = $this->suplimentryAgendaRepository->getScheduleMeeting();

        return view('suplimentry-agenda.index')->with([
            'suplimentryAgendas' => $suplimentryAgendas,
            'scheduleMeetings' => $scheduleMeetings
        ]);
    }

    public function store(SuplimentryAgendaRequest $request)
    {
        $suplimentryAgenda = $this->suplimentryAgendaRepository->store($request);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Agenda created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $suplimentryAgenda = $this->suplimentryAgendaRepository->edit($id);

        if ($suplimentryAgenda) {
            $response = [
                'result' => 1,
                'suplimentryAgenda' => $suplimentryAgenda,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(SuplimentryAgendaRequest $request, $id)
    {
        $suplimentryAgenda = $this->suplimentryAgendaRepository->update($request, $id);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Agenda updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $suplimentryAgenda = $this->suplimentryAgendaRepository->destroy($id);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Agenda deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
