<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Goshwara;
use App\Models\Meeting;

class GoshwaraRepository
{
    public function index($request)
    {
        $goshwara = Goshwara::when(isset($request->from) && $request->from != "", function ($q) use ($request) {
            return $q->whereDate('date', '>=', date('Y-m-d', strtotime($request->from)));
        })->when(isset($request->to) && $request->to != "", function ($q) use ($request) {
            return $q->whereDate('date', '<=', date('Y-m-d', strtotime($request->to)));
        })->when(Auth::user()->hasRole('Clerk'), function ($query) {
            return $query->where('meeting_id', Auth::user()->meeting_id);
        })->where('is_sent', 1)->with(['meeting', 'department', 'assignGoshwaraToAgenda']);

        if (Auth::user()->roles[0]->name == "Department")
            $goshwara = $goshwara->where('department_id', Auth::user()->department_id)->latest()->get();
        else
            $goshwara = $goshwara->latest()->get();

        return $goshwara;
    }

    public function getMeetingName()
    {
        return Meeting::get();
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
            $request['department_id'] = Auth::user()->department_id;
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
        DB::beginTransaction();
        try {
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
            DB::rollback();
            return false;
        }
    }

    // function to get send list
    public function send($request)
    {
        $goshwara = Goshwara::with(['meeting'])->where('is_sent', 0)->latest()->where('department_id', Auth::user()->department_id)->orderBy('updated_at', 'desc')->get();

        return $goshwara;
    }

    public function postSend($request)
    {
        DB::beginTransaction();
        try {
            $goshwara = Goshwara::find($request->id);
            $goshwara->sent_by = Auth::user()->id;
            $goshwara->date = date('Y-m-d H:i:s');
            $goshwara->is_sent = 1;
            $goshwara->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public function show($id)
    {
        return Goshwara::with(['department', 'sentBy', 'meeting'])->where('id', $id)->first();
    }

    // public function getSelectedStatus($status)
    // {
    //     return Goshwara::with(['department', 'meeting'])->where([
    //         'is_mayor_selected' => $status,
    //         'is_sent' => 1
    //     ])->get();
    // }

    // public function saveMayorSelectedStatus($request)
    // {
    //     $goshwara = Goshwara::find($request->id);
    //     $goshwara->is_mayor_selected = 1;
    //     $goshwara->selected_datetime = date('Y-m-d h:i:s');
    //     $goshwara->selected_by = Auth::user()->id;

    //     if ($goshwara->save()) {
    //         return true;
    //     }
    // }
}
