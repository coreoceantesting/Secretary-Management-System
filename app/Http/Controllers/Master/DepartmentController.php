<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\DepartmentRepository;
use App\Http\Requests\Master\DepartmentRequest;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $departments = $this->departmentRepository->index();

        return view('master.department.department')->with([
            'departments' => $departments
        ]);
    }

    public function store(DepartmentRequest $request)
    {
        $department = $this->departmentRepository->store($request);

        if ($department) {
            return response()->json(['success' => 'Department created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $department = $this->departmentRepository->edit($id);

        if ($department) {
            $response = [
                'result' => 1,
                'department' => $department,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = $this->departmentRepository->update($request, $id);

        if ($department) {
            return response()->json(['success' => 'Department updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $department = $this->departmentRepository->destroy($id);

        if ($department) {
            return response()->json(['success' => 'Department deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}