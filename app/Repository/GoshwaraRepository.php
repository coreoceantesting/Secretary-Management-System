<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Goshwara;

class GoshwaraRepository
{
    public function index($request)
    {
        $goshwara = Goshwara::when(isset($request->from) && $request->from != "", function ($q) use ($request) {
            return $q->whereDate('date', '>=', date('Y-m-d', strtotime($request->from)));
        })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
            return $q->whereDate('date', '<=', date('Y-m-d', strtotime($request->to)));
        })->where('is_sent', 1)->with(['department', 'sentBy'])->latest()->get();

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
            $file = $goshwara->file;
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

    // function to get send list
    public function send($request)
    {
        $goshwara = Goshwara::where('is_sent', 0)->latest()->get();

        return $goshwara;
    }

    public function postSend($request)
    {
        try {
            DB::beginTransaction();
            $goshwara = Goshwara::find($request->id);
            $goshwara->sent_by = Auth::user()->id;
            $goshwara->date = date('Y-m-d h:i:s');
            $goshwara->is_sent = 1;
            $goshwara->department_id = Auth::user()->department?->id;
            $goshwara->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function show($id)
    {
        return Goshwara::with(['department', 'sentBy'])->where('id', $id)->first();
    }
}
