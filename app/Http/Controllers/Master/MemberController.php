<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\MemberRepository;
use App\Repository\Master\WardRepository;
use App\Http\Requests\Master\MemberRequest;
use App\Models\Party;
use App\Models\ReservationCategory;

class MemberController extends Controller
{
    protected $memberRepository;
    protected $wardRepository;

    public function __construct(MemberRepository $memberRepository, WardRepository $wardRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->wardRepository = $wardRepository;
    }

    public function index()
    {
        $members = $this->memberRepository->index();

        $wards = $this->wardRepository->index();

        $parties = Party::select('id', 'name')->get();

        $reservationCategory = ReservationCategory::select('id', 'name')->get();

        return view('master.member.member')->with([
            'members' => $members,
            'wards' => $wards,
            'parties' => $parties,
            'reservationCategory' => $reservationCategory
        ]);
    }

    public function store(MemberRequest $request)
    {
        $member = $this->memberRepository->store($request);

        if ($member) {
            return response()->json(['success' => 'Member created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $member = $this->memberRepository->edit($id);

        if ($member) {
            $response = [
                'result' => 1,
                'member' => $member,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(MemberRequest $request, $id)
    {
        $member = $this->memberRepository->update($request, $id);

        if ($member) {
            return response()->json(['success' => 'Member updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $member = $this->memberRepository->destroy($id);

        if ($member) {
            return response()->json(['success' => 'Member deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }
}
