<?php

namespace App\Repository\Master;

use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeetingRepository
{
    public function index()
    {
        $meetings = Meeting::select('id', 'name', 'head_person_name', 'head_person_designation')->get();

        return $meetings;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            Meeting::create($request->all());

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
        $meeting = Meeting::find($id);

        return $meeting;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $meeting = Meeting::find($id);
            $meeting->update($request->all());

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
            $meeting = Meeting::find($id);
            $meeting->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}