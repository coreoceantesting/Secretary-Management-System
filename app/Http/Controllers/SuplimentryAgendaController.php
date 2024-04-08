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

        $meetings = $this->suplimentryAgendaRepository->getMeetings();

        return view('suplimentry-agenda.index')->with([
            'suplimentryAgendas' => $suplimentryAgendas,
            'meetings' => $meetings
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

        $scheduleMeetings = $this->suplimentryAgendaRepository->getScheduleMeeting($suplimentryAgenda->meeting_id);

        $scheduleMeetingDateTime = '<label class="col-form-label" for="schedule_meeting_id">
                Select Schedule Meeting Date
                <span class="text-danger">*</span>
            </label>
            <select class="form-select col-sm-12 selectChnageScheduleMeetingDetails" id="schedule_meeting_id" name="schedule_meeting_id">
                <option value="">--Select Schedule Meeting--</option>';

        foreach ($scheduleMeetings as $scheduleMeeting) :
            $isSelected = $scheduleMeeting->id == $suplimentryAgenda->schedule_meeting_id ? 'selected' : '';
            $scheduleMeetingDateTime .= '<option value="' . $scheduleMeeting->id . '" ' . $isSelected . '>' . date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) . '</option>';
        endforeach;
        $scheduleMeetingDateTime .= '</select>';


        if ($suplimentryAgenda) {
            $response = [
                'result' => 1,
                'suplimentryAgenda' => $suplimentryAgenda,
                'scheduleMeetingDateTime' => $scheduleMeetingDateTime,
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

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->suplimentryAgendaRepository->getScheduleMeeting($id);

            $results = $scheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  $item["unique_id"] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
                $item["id"] =  $item["id"];
                return $item;
            });


            return response()->json([
                'status' => 200,
                'data' => $results
            ]);
        }
    }
}
