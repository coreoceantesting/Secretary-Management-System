<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\SettingRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\Master\SettingRequest;

class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $seetings = $this->settingRepository->index();

        return view('master.setting.index')->with([
            'seetings' => $seetings
        ]);
    }

    // function to store meeting
    public function store(SettingRequest $request)
    {
        $seeting = $this->settingRepository->store($request);

        if ($seeting) {
            return response()->json(['success' => 'Setting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to edit the meeting by id
    public function edit($id)
    {
        $seeting = $this->settingRepository->edit($id);

        if ($seeting) {
            $response = [
                'result' => 1,
                'seeting' => $seeting,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    // function to update the setting
    public function update(SettingRequest $request, $id)
    {
        $department = $this->settingRepository->update($request, $id);

        if ($department) {
            return response()->json(['success' => 'Setting updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to delete the seeting
    public function destroy($id)
    {
        $meeting = $this->settingRepository->destroy($id);

        if ($meeting) {
            return response()->json(['success' => 'Setting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
