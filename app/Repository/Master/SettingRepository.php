<?php

namespace App\Repository\Master;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingRepository
{
    public function index()
    {
        $meetings = Setting::get();

        return $meetings;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            if ($request->status == "1") {
                Setting::where('meeting_id', $request->meeting_id)->update(['status' => 0]);
            }

            Setting::create($request->all());

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return false;
        }
    }

    public function edit($id)
    {
        $setting = Setting::find($id);

        return $setting;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->status == "1") {
                Setting::where('meeting_id', $request->meeting_id)->update(['status' => 0]);
            }

            $setting = Setting::find($id);
            $setting->update($request->all());

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $setting = Setting::find($id);
            $setting->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
