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
    protected $commonRepository;

    public function __construct(SettingRepository $settingRepository, CommonRepository $commonRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $settings = $this->settingRepository->index();

        $meetings = $this->commonRepository->getMeeting();

        return view('master.setting.index')->with([
            'settings' => $settings,
            'meetings' => $meetings
        ]);
    }

    // function to store meeting
    public function store(SettingRequest $request)
    {
        $setting = $this->settingRepository->store($request);

        if ($setting) {
            return response()->json(['success' => 'Setting created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    // function to edit the meeting by id
    public function edit($id)
    {
        $setting = $this->settingRepository->edit($id);

        if ($setting) {
            $response = [
                'result' => 1,
                'setting' => $setting,
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

    // function to delete the setting
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
