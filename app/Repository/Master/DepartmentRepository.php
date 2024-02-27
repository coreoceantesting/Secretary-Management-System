<?php

namespace App\Repository\Master;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentRepository
{
    public function index()
    {
        $departments = Department::select('id', 'name', 'initial')->where('is_home_department', 0)->get();

        return $departments;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $request['is_home_department'] = "0";
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
        $department = Department::find($id);

        return $department;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $department = Department::find($id);
            $department->update($request->all());

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
            $department = Department::find($id);
            $department->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}