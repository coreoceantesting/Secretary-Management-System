<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AgendaRepository;
use App\Http\Requests\AgendaRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use PDF;

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

        // $goshwaras = $this->agendaRepository->getNotAssignedGoshwara();

        $meetings = $this->agendaRepository->getMeetings();

        return view('agenda.index')->with([
            'agendas' => $agendas,
            'meetings' => $meetings
        ]);
    }

    public function selectMeeting(Request $request)
    {
        if ($request->ajax()) {
            $goshwaras = $this->agendaRepository->getAddNotAssignedGoshwara($request->meeting_id);

            if ($goshwaras) {
                return response()->json(['goshwaras' => $goshwaras]);
            } else {
                return response()->json(['error' => 'Something went wrong please try again']);
            }
        }
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

        $goshwaras = $this->agendaRepository->getAssignedGoshwaraById($id, $agenda->meeting_id);
        $notAssignedGoshwaras = $this->agendaRepository->getNotAssignedGoshwara($agenda->meeting_id);

        $goshwaraHtml = '';
        foreach ($goshwaras as $goshwara) {
            $goshwaraHtml .= '<tr>
                                    <td>
                                        <input type="checkbox" name="goshwara_id[]" value="' . $goshwara->id . '" class="form-check" checked>
                                    </td>
                                    <td>' . $goshwara?->meeting->name . '</td>
                                    <td>' . $goshwara->name . '</td>
                                    <td>' . $goshwara->subject . '</td>
                                    <td><a href="' . asset("storage/") . $goshwara->file . '" class="btn btn-primary btn-sm">View</a></td>
                                </tr>';
        }

        foreach ($notAssignedGoshwaras as $notAssignedGoshwara) {
            $goshwaraHtml .= '<tr>
                                    <td>
                                        <input type="checkbox" name="goshwara_id[]" value="' . $notAssignedGoshwara->id . '" class="form-check">
                                    </td>
                                    <td>' . $notAssignedGoshwara?->meeting->name . '</td>
                                    <td>' . $notAssignedGoshwara->name . '</td>
                                    <td>' . $notAssignedGoshwara->subject . '</td>
                                    <td><a href="' . asset("storage/") . $notAssignedGoshwara->file . '" class="btn btn-primary btn-sm">View</a></td>
                                </tr>';
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

        if (Auth::user()->hasRole('Mayor')) {
            Agenda::where('id', $id)->update([
                'is_mayor_view' => 1,
                'mayor_view_datetime' => now()
            ]);
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

    public function generatePdf()
    {
        $pdf = PDF::loadView('agenda.pdf');

        return $pdf->stream('document.pdf');
    }

    public function receipt(Request $request)
    {
        $agenda = Agenda::with(['assignGoshwaraToAgenda.goshwara.department'])->find($request->id);

        $pdf = PDF::loadView('agenda.receipt', compact('agenda'));

        return $pdf->stream('document.pdf');
    }
}
