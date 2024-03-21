<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AgendaRepository;
use App\Http\Requests\AgendaRequest;

class AgendaController extends Controller
{
    protected $agendaRepository;

    public function __construct(AgendaRepository $agendaRepository)
    {
        $this->agendaRepository = $agendaRepository;
    }

    public function index()
    {
        $agendas = $this->agendaRepository->index();

        return view('agenda.index')->with([
            'agendas' => $agendas
        ]);
    }

    public function store(AgendaRequest $request)
    {
        $agenda = $this->agendaRepository->store($request);

        if ($agenda) {
            return response()->json(['success' => 'Agenda created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $agenda = $this->agendaRepository->edit($id);

        if ($agenda) {
            $response = [
                'result' => 1,
                'agenda' => $agenda,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(AgendaRequest $request, $id)
    {
        $agenda = $this->agendaRepository->update($request, $id);

        if ($agenda) {
            return response()->json(['success' => 'Agenda updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $agenda = $this->agendaRepository->destroy($id);

        if ($agenda) {
            return response()->json(['success' => 'Agenda deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
