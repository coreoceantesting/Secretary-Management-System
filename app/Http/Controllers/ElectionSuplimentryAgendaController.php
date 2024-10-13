<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ElectionSuplimentryAgendaRepository;
use App\Http\Requests\SuplimentryAgendaRequest;

class ElectionSuplimentryAgendaController extends Controller
{
    protected $electionSuplimentryAgendaRepository;

    public function __construct(ElectionSuplimentryAgendaRepository $electionSuplimentryAgendaRepository)
    {
        $this->electionSuplimentryAgendaRepository = $electionSuplimentryAgendaRepository;
    }

    public function index()
    {
        $suplimentryAgendas = $this->electionSuplimentryAgendaRepository->index();

        $meetings = $this->electionSuplimentryAgendaRepository->getMeetings();

        return view('election.suplimentry-agenda.index')->with([
            'suplimentryAgendas' => $suplimentryAgendas,
            'meetings' => $meetings
        ]);
    }

    public function store(SuplimentryAgendaRequest $request)
    {
        $suplimentryAgenda = $this->electionSuplimentryAgendaRepository->store($request);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Election suplimentry agenda created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $suplimentryAgenda = $this->electionSuplimentryAgendaRepository->edit($id);

        $scheduleMeetings = $this->electionSuplimentryAgendaRepository->getScheduleMeeting($suplimentryAgenda->election_meeting_id);

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
        $suplimentryAgenda = $this->electionSuplimentryAgendaRepository->update($request, $id);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Election suplimentry agenda updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $suplimentryAgenda = $this->electionSuplimentryAgendaRepository->destroy($id);

        if ($suplimentryAgenda) {
            return response()->json(['success' => 'Election suplimentry agenda deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->electionSuplimentryAgendaRepository->getScheduleMeeting($id);

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
