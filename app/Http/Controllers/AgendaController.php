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

        $goshwaras = $this->agendaRepository->getNotAssignedGoshwara();

        return view('agenda.index')->with([
            'agendas' => $agendas,
            'goshwaras' => $goshwaras
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

        $goshwaras = $this->agendaRepository->getAssignedGoshwaraById($id);
        $notAssignedGoshwaras = $this->agendaRepository->getNotAssignedGoshwara();

        $goshwaraHtml = '<option value="">--Select Goshwara--</option>';
        foreach ($goshwaras as $goshwara) {
            $goshwaraHtml .= '<option selected value="' . $goshwara->id . '">' . $goshwara->name . '</option>';
        }

        foreach ($notAssignedGoshwaras as $notAssignedGoshwara) {
            $goshwaraHtml .= '<option value="' . $notAssignedGoshwara->id . '">' . $notAssignedGoshwara->name . '</option>';
        }

        if ($agenda) {
            $response = [
                'result' => 1,
                'agenda' => $agenda,
                'goshwaraHtml' => $goshwaraHtml
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
