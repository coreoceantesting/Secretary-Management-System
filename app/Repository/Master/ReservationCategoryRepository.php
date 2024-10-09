<?php

namespace App\Repository\Master;

use App\Models\ReservationCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationCategoryRepository
{

    public function index()
    {
        return ReservationCategory::select('id', 'name')->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            ReservationCategory::create($request->all());

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
        return ReservationCategory::find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $reservationCategory = ReservationCategory::find($id);
            $reservationCategory->update($request->all());

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
            $reservationCategory = ReservationCategory::find($id);
            $reservationCategory->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
