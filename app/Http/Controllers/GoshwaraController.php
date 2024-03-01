<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\GoshwaraRepository;
use App\Http\Requests\GoshwaraRequest;

class GoshwaraController extends Controller
{
    protected $goshwaraRepository;

    public function __construct(GoshwaraRepository $goshwaraRepository)
    {
        $this->goshwaraRepository = $goshwaraRepository;
    }

    public function index(Request $request)
    {
        $goshwaras = $this->goshwaraRepository->index($request);

        return view('goshwara.index')->with([
            'goshwaras' => $goshwaras
        ]);
    }

    public function create()
    {
        return view('goshwara.create');
    }

    public function store(GoshwaraRequest $request)
    {
        $goshwara = $this->goshwaraRepository->store($request);

        if ($goshwara) {
            return redirect()->route('goshwara.send')->with('success', 'Goshwara created successfully!');
        } else {
            return redirect()->route('goshwara.send')->with('error', 'Something went wrong please try again');
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
    public function update(GoshwaraRequest $request, $id)
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

    public function send(Request $request)
    {
        $goshwaras = $this->goshwaraRepository->send($request);

        return view('goshwara.send')->with([
            'goshwaras' => $goshwaras
        ]);
    }

    // function to update send request
    public function postSend(Request $request)
    {
        $goshwara = $this->goshwaraRepository->postSend($request);

        if ($goshwara) {
            return redirect()->route('goshwara.index')->with('success', 'Goshwara send successfully!');
        } else {
            return back()->with('error', 'Something went wrong please try again');
        }
    }

    public function show($id)
    {
        $goshwara = $this->goshwaraRepository->show($id);

        return view('goshwara.show')->with([
            'goshwara' => $goshwara
        ]);
    }
}
