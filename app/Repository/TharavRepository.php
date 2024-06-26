<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Tharav;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\ScheduleMeeting;
use App\Models\AssignDepartmentToTharav;

class TharavRepository
{
    public function index()
    {
        $tharav = Tharav::with(['meeting', 'assignTharavDepartment.department', 'scheduleMeeting'])
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->where('meeting_id', Auth::user()->meeting_id);
            });;

        if (Auth::user()->hasRole('Department')) {
            $tharav = $tharav->whereHas('assignTharavDepartment', function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            });
        }

        $tharav = $tharav->latest()->get();

        return $tharav;
    }

    public function getScheduleMeeting($id)
    {
        return ScheduleMeeting::where('meeting_id', $id)->where([
            'is_record_proceeding' => 1
        ])->get();
    }

    public function getScheduleMeetingDepartment($id)
    {
        return AssignScheduleMeetingDepartment::with(['department'])->where('schedule_meeting_id', $id)->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $request['date'] = date('Y-m-d', strtotime($request->date));
            $request['time'] = date('h:i:s', strtotime($request->time));
            $request['datetime'] = date('Y-m-d', strtotime($request->date)) . " " . date('h:i:s', strtotime($request->time));

            $file = null;
            if ($request->hasFile('uploadfile')) {
                $file = $request->uploadfile->store('tharav');
            }
            $request['file'] = $file;

            $tharav = Tharav::create($request->all());

            if (isset($request->department_id)) {
                for ($i = 0; $i < count($request->department_id); $i++) {
                    AssignDepartmentToTharav::create([
                        'tharav_id' => $tharav->id,
                        'department_id' => $request->department_id[$i]
                    ]);
                }
            }

            ScheduleMeeting::where('id', $request->schedule_meeting_id)->update([
                'is_tharav_uploaded' => 1
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }
    }
}
