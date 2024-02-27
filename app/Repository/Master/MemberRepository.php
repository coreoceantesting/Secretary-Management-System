<?php

namespace App\Repository\Master;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberRepository
{
    public function index()
    {
        $members = Member::with(['ward'])->select('id', 'ward_id', 'name', 'contact_number', 'email', 'political_party', 'address', 'designation')->get();

        return $members;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            Member::create($request->all());

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
        $member = Member::find($id);

        return $member;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $member = Member::find($id);
            $member->update($request->all());

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
            $member = Member::find($id);
            $member->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function assignMemberToMeeting($id)
    {
    }
}
