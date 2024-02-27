<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Goshwara;

class GoshwaraRepository
{
    public function index()
    {
        $goshwara = Goshwara::with(['department', 'meeting'])->get();

        return $goshwara;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $file = null;
            if ($request->hasFile('goshwarafile')) {
                $file = $request->goshwarafile->store('goshwara');
            }
            $request['file'] = $file;
            Goshwara::create($request->all());

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
        $goshwara = Goshwara::find($id);

        return $goshwara;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $goshwara = Goshwara::find($id);
            $file = $goshwara->goshwarafile;
            if ($request->hasFile('goshwarafile')) {
                if ($goshwara->file != "") {
                    if (Storage::exists($goshwara->file)) {
                        Storage::delete($goshwara->file);
                    }
                }
                $file = $request->goshwarafile->store('goshwara');
            }
            $request['file'] = $file;
            $goshwara->update($request->all());

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
            $goshwara = Goshwara::find($id);
            if ($goshwara->file != "") {
                if (Storage::exists($goshwara->file)) {
                    Storage::delete($goshwara->file);
                }
            }

            $goshwara->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
