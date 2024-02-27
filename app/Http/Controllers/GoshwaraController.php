<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\GoshwaraRepository;

class GoshwaraController extends Controller
{
    protected $goshwaraRepository;

    public function __construct(GoshwaraRepository $goshwaraRepository)
    {
        $this->goshwaraRepository = $goshwaraRepository;
    }

    public function index()
    {
        $goshwaras = $this->goshwaraRepository->index();

        return view('goshwara.index')->with([
            'goshwaras' => $goshwaras
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $goshwara = $this->goshwaraRepository->store($request);

        if ($goshwara) {
            return response()->json(['success' => 'Goshwara created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to edit the goshwara by id
    public function edit($id)
    {
        $goshwara = $this->goshwaraRepository->edit($id);

        if ($goshwara) {
            $response = [
                'result' => 1,
                'goshwara' => $goshwara,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    // function to update the goshwara
    public function update(Request $request, $id)
    {
        $goshwara = $this->goshwaraRepository->update($request, $id);

        if ($goshwara) {
            return response()->json(['success' => 'Goshwara updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to delete the goshwara
    public function destroy($id)
    {
        $goshwara = $this->goshwaraRepository->destroy($id);

        if ($goshwara) {
            return response()->json(['success' => 'Goshwara deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
