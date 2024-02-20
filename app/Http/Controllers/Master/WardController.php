<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\WardRepository;
use App\Http\Requests\Master\WardRequest;

class WardController extends Controller
{
    protected $wardRepository;

    public function __construct(WardRepository $wardRepository)
    {
        $this->wardRepository = $wardRepository;
    }

    public function index()
    {
        $wards = $this->wardRepository->index();

        return view('master.ward.ward')->with([
            'wards' => $wards
        ]);
    }

    public function store(WardRequest $request)
    {
        $ward = $this->wardRepository->store($request);

        if ($ward) {
            return response()->json(['success' => 'Ward created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $ward = $this->wardRepository->edit($id);

        if ($ward) {
            $response = [
                'result' => 1,
                'ward' => $ward,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(WardRequest $request, $id)
    {
        $ward = $this->wardRepository->update($request, $id);

        if ($ward) {
            return response()->json(['success' => 'Ward updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $ward = $this->wardRepository->destroy($id);

        if ($ward) {
            return response()->json(['success' => 'Ward deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}