<?php

namespace App\Repository\Master;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeDepartmentRepository
{
    public function index()
    {
        $homeDepartments = Department::select('id', 'name', 'initial')->where('is_home_department', 1)->get();

        return $homeDepartments;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $request['is_home_department'] = "1";
            Department::create($request->all());

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
        $homeDepartment = Department::find($id);

        return $homeDepartment;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $homeDepartment = Department::find($id);
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
            $homeDepartment = Department::find($id);
            $homeDepartment->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}