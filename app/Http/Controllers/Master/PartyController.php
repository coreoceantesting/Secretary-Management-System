<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\PartyRepository;
use App\Http\Requests\Master\PartyRequest;

class PartyController extends Controller
{
    protected $partyRepository;

    public function __construct(PartyRepository $partyRepository)
    {
        $this->partyRepository = $partyRepository;
    }

    public function index()
    {
        $parties = $this->partyRepository->index();

        return view('master.party.index')->with([
            'parties' => $parties
        ]);
    }

    public function store(PartyRequest $request)
    {
        $party = $this->partyRepository->store($request);

        if ($party) {
            return response()->json(['success' => 'Party created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $party = $this->partyRepository->edit($id);

        if ($party) {
            $response = [
                'result' => 1,
                'party' => $party,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(PartyRequest $request, $id)
    {
        $party = $this->partyRepository->update($request, $id);

        if ($party) {
            return response()->json(['success' => 'Party updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $party = $this->partyRepository->destroy($id);

        if ($party) {
            return response()->json(['success' => 'Party deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
