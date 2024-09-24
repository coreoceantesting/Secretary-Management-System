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
            if ($request->hasFile('photos')) {
                $request['photo'] = $request->photos->store('members');
            }

            if ($request->hasFile('aadhars')) {
                $request['aadhar'] = $request->aadhars->store('members');
            }

            if ($request->hasFile('pancards')) {
                $request['pancard'] = $request->pancards->store('members');
            }

            if ($request->hasFile('bank_detailss')) {
                $request['bank_details'] = $request->bank_detailss->store('members');
            }

            if ($request->hasFile('cancel_cheques')) {
                $request['cancel_cheque'] = $request->cancel_cheques->store('members');
            }
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

            if ($request->hasFile('photos')) {
                if ($member->photo != "") {
                    if (Storage::exists($member->photo)) {
                        Storage::delete($member->photo);
                    }
                }
                $request['photo'] = $request->photos->store('members');
            }

            if ($request->hasFile('aadhars')) {
                if ($member->aadhar != "") {
                    if (Storage::exists($member->aadhar)) {
                        Storage::delete($member->aadhar);
                    }
                }
                $request['aadhar'] = $request->aadhars->store('members');
            }

            if ($request->hasFile('pancards')) {
                if ($member->pancard != "") {
                    if (Storage::exists($member->pancard)) {
                        Storage::delete($member->pancard);
                    }
                }
                $request['pancard'] = $request->pancards->store('members');
            }

            if ($request->hasFile('bank_detailss')) {
                if ($member->bank_details != "") {
                    if (Storage::exists($member->bank_details)) {
                        Storage::delete($member->bank_details);
                    }
                }
                $request['bank_details'] = $request->bank_detailss->store('members');
            }

            if ($request->hasFile('cancel_cheques')) {
                if ($member->cancel_cheque != "") {
                    if (Storage::exists($member->cancel_cheque)) {
                        Storage::delete($member->cancel_cheque);
                    }
                }
                $request['cancel_cheque'] = $request->cancel_cheques->store('members');
            }

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

    public function assignMemberToMeeting($id) {}
}
