<?php

namespace App\Repository\Master;

use App\Models\HomeDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeDepartmentRepository
{
    public function index()
    {
        $homeDepartments = HomeDepartment::select('id', 'name', 'initial')->get();

        return $homeDepartments;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            HomeDepartment::create($request->all());

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
        $homeDepartment = HomeDepartment::find($id);

        return $homeDepartment;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $homeDepartment = HomeDepartment::find($id);
            $homeDepartment->update($request->all());

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
            $homeDepartment = HomeDepartment::find($id);
            $homeDepartment->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}