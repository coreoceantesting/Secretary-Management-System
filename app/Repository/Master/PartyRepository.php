<?php

namespace App\Repository\Master;

use App\Models\Party;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartyRepository
{
    public function index()
    {
        $party = Party::select('id', 'name')->get();

        return $party;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            Party::create($request->all());

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
        $party = Party::find($id);

        return $party;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $party = Party::find($id);
            $party->update($request->all());

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
            $party = Party::find($id);
            $party->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
