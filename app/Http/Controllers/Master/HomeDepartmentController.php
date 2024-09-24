<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\HomeDepartmentRepository;

class HomeDepartmentController extends Controller
{
    protected $homeDepartmentRepository;

    public function __construct(HomeDepartmentRepository $homeDepartmentRepository)
    {
        $this->homeDepartmentRepository = $homeDepartmentRepository;
    }

    public function index()
    {
        $homeDepartments = $this->homeDepartmentRepository->index();

        return view('master.home-department.home-department')->with([
            'homeDepartments' => $homeDepartments
        ]);
    }

    public function store(Request $request)
    {
        $department = $this->homeDepartmentRepository->store($request);

        if ($department) {
            return response()->json(['success' => 'Home Department created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $homeDepartment = $this->homeDepartmentRepository->edit($id);

        if ($homeDepartment) {
            $response = [
                'result' => 1,
                'homeDepartment' => $homeDepartment,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(Request $request, $id)
    {
        $department = $this->homeDepartmentRepository->update($request, $id);

        if ($department) {
            return response()->json(['success' => 'Home Department updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $department = $this->homeDepartmentRepository->destroy($id);

        if ($department) {
            return response()->json(['success' => 'home Department deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
