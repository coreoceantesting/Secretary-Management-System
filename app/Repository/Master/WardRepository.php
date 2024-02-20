<?php

namespace App\Repository\Master;

use App\Models\Ward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WardRepository
{
    public function index()
    {
        $wards = Ward::select('id', 'name', 'initial')->get();

        return $wards;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            Ward::create($request->all());

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
        $ward = Ward::find($id);

        return $ward;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $ward = Ward::find($id);
            $ward->update($request->all());

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
            $ward = Ward::find($id);
            $ward->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}