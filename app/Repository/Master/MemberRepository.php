<?php

namespace App\Repository\Master;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberRepository
{
    public function index()
    {
        $members = Member::with(['ward', 'party'])->select('id', 'ward_id', 'name', 'contact_number', 'email', 'address', 'designation', 'party_id')->latest()->get();

        return $members;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('photos')) {
                $file = $request->photos->store('members');
            }
            $request['photo'] = $file;
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

            $file = $member->photo;
            if ($request->hasFile('photos')) {
                if ($member->photo != "") {
                    if (Storage::exists($member->photo)) {
                        Storage::delete($member->photo);
                    }
                }
                $file = $request->photos->store('members');
            }
            $request['photo'] = $file;

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
