<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\ReservationCategoryRepository;
use App\Http\Requests\Master\ReservationCategoryRequest;

class ReservationCategoryController extends Controller
{
    protected $reservationCategoryRepository;

    public function __construct(ReservationCategoryRepository $reservationCategoryRepository)
    {
        $this->reservationCategoryRepository = $reservationCategoryRepository;
    }

    public function index()
    {
        $reservationCategory = $this->reservationCategoryRepository->index();

        return view('master.reservation-category.index')->with([
            'reservationCategory' => $reservationCategory
        ]);
    }

    public function store(ReservationCategoryRequest $request)
    {
        $reservationCategory = $this->reservationCategoryRepository->store($request);

        if ($reservationCategory) {
            return response()->json(['success' => 'Reservation category created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $reservationCategory = $this->reservationCategoryRepository->edit($id);

        if ($reservationCategory) {
            $response = [
                'result' => 1,
                'reservationCategory' => $reservationCategory,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(ReservationCategoryRequest $request, $id)
    {
        $reservationCategory = $this->reservationCategoryRepository->update($request, $id);

        if ($reservationCategory) {
            return response()->json(['success' => 'Reservation category updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $reservationCategory = $this->reservationCategoryRepository->destroy($id);

        if ($reservationCategory) {
            return response()->json(['success' => 'Reservation category deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
