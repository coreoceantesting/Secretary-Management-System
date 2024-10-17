<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectionAgenda;
use App\Models\ElectionMeeting;
use App\Models\Department;
use App\Models\ElectionScheduleMeeting;
use App\Models\ElectionAssignMemberToMeeting;
use App\Models\ElectionAssignScheduleMeetingDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\ScheduleMeetingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\UserElectionMeeting;

class ElectionScheduleMeetingController extends Controller
{
    public function index()
    {
        $agendas = ElectionAgenda::where('is_meeting_schedule', 0)
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->whereIn('id', UserElectionMeeting::where('user_id', Auth::user()->id)->pluck('election_meeting_id')->toArray());
            })->get();

        $meetings = ElectionMeeting::get();

        $departments = Department::where('is_home_department', 0)->get();

        $electionScheduleMeetings = ElectionScheduleMeeting::with(['electionMeeting', 'electionAgenda'])
            ->whereNull('election_schedule_meeting_id')
            ->where([
                'is_meeting_reschedule' => 0,
            ])
            ->when(Auth::user()->hasRole('Clerk'), function ($query) {
                return $query->whereIn('election_meeting_id', UserElectionMeeting::where('user_id', Auth::user()->id)->pluck('election_meeting_id')->toArray());
            })
            ->whereDate('date', '>=', date('Y-m-d'))->latest()->get();

        return view('election.schedule-meeting.index')->with([
            'agendas' => $agendas,
            'meetings' => $meetings,
            'departments' => $departments,
            'electionScheduleMeetings' => $electionScheduleMeetings
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $check = ElectionScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
                    ->where('time', date('H:i:s', strtotime($request->time)))
                    ->where('is_meeting_cancel', '!=', 0)
                    ->where('election_meeting_id', $request->election_meeting_id)->exists();

                if ($check) {
                    return response()->json(['error' => 'Election meeting already created on date time ' . date('d-m-Y h:i A', strtotime($request->date . ' ' . $request->time)) . '. Please select diffrent datetime']);
                }


                DB::beginTransaction();
                try {
                    // get meeting Name
                    $meetingName = ElectionMeeting::where('id', $request->election_meeting_id)->value('name');

                    // get schedule meeting count
                    $count = ElectionScheduleMeeting::where('election_meeting_id', $request->election_meeting_id)->count();
                    $uniqueCount = $meetingName . ' क्र. ' . $count + 1;


                    $date = date('Y-m-d', strtotime($request->date));
                    $time = date('H:i:s', strtotime($request->time));

                    $request['date'] = $date;
                    $request['time'] = $time;
                    $request['unique_id'] = $uniqueCount;
                    $request['datetime'] = $date . " " . $time;
                    $scheduleMeeting = ElectionScheduleMeeting::create($request->all());

                    // update parent_id
                    ElectionScheduleMeeting::where('id', $scheduleMeeting->id)->update(['parent_id' => $scheduleMeeting->id]);

                    // logic to assign schedule meeting to department
                    if (isset($request->department_id)) {
                        for ($i = 0; $i < count($request->department_id); $i++) {
                            $assignScheduleMeetingDepartment = new ElectionAssignScheduleMeetingDepartment;
                            $assignScheduleMeetingDepartment->election_schedule_meeting_id = $scheduleMeeting->id;
                            $assignScheduleMeetingDepartment->department_id = $request->department_id[$i];
                            $assignScheduleMeetingDepartment->save();
                        }
                    }
                    // end of logic to assign schedule meeting to department

                    // change agenda schedule meeting status
                    ElectionAgenda::where('id', $request->election_agenda_id)->update([
                        'is_meeting_schedule' => 1
                    ]);


                    // logic to send sms and email
                    // $members = ElectionAssignMemberToMeeting::with(['member'])->where('meeting_id', $request->meeting_id)->get();

                    // $scheduleMeeting = ElectionScheduleMeeting::with(['agenda', 'meeting'])->where('id', $scheduleMeeting->id)->first();

                    // foreach ($members as $member) {
                    //     Log::info('Sms Send to number' . $member->member->contact_number);
                    //     Mail::to($member->member->email)->send(new ScheduleMeetingMail($scheduleMeeting));
                    // }
                    // end of send sms and email login


                    DB::commit();
                    return response()->json(['success' => 'Election schedule meeting created successfully!']);
                } catch (\Exception $e) {
                    Log::info($e);
                    DB::rollback();
                    return response()->json(['error' => 'Something went wrong']);
                }
            } catch (\Exception $e) {
                Log::info($e);
                return response()->json([
                    'error' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function fetchAgenda(Request $request)
    {
        if ($request->ajax()) {
            $agenda = ElectionAgenda::find($request->election_agenda_id);

            return response()->json(['agenda' => $agenda]);
        }
    }

    public function cancel(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $scheduleMeeting = ElectionScheduleMeeting::find($id);
                $scheduleMeeting->is_meeting_cancel = 1;
                $scheduleMeeting->cancel_remark = $request->remark;
                $scheduleMeeting->cancel_meeting_date = date('Y-m-d');
                $scheduleMeeting->save();

                ElectionAgenda::where('id', $scheduleMeeting->election_agenda_id)->update([
                    'is_meeting_schedule' => 0
                ]);

                DB::commit();

                return response()->json(['success' => 'Election schedule meeting cancel successfully!']);
            } catch (\Exception $e) {
                Log::info($e);
                DB::rollback();
                return response()->json(['error' => 'Something went wrong']);
            }
        }
    }

    public function show($id)
    {
        $scheduleMeeting = ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting', 'assignScheduleMeetingDepartment.department'])->where('id', $id)->first();

        return view('election.schedule-meeting.show')->with(['scheduleMeeting' => $scheduleMeeting]);
    }
}
