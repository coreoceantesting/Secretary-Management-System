<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectionAgenda;
use App\Models\ElectionMeeting;
use App\Models\Department;
use App\Models\ElectionScheduleMeeting;
use App\Models\ElectionAssignScheduleMeetingDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\RescheduleMeetingMail;
use App\Models\Meeting;
use Illuminate\Support\Facades\Mail;

class ElectionRescheduleMeetingController extends Controller
{
    public function index()
    {
        $agendas = ElectionAgenda::where('is_meeting_schedule', 0)->get();

        $meetings = ElectionMeeting::whereHas('electionScheduleMeeting', function ($q) {
            return $q->where([
                'is_meeting_cancel' => 0,
                'is_meeting_reschedule' => 0,
                'is_meeting_completed' => 0
            ]);
        })->get();

        $departments = Department::where('is_home_department', 0)->get();

        $rescheduleMeetings = ElectionScheduleMeeting::with(['electionMeeting', 'electionAgenda'])
            ->whereNotNull('election_schedule_meeting_id')
            ->where([
                'is_meeting_reschedule' => 0,
                'is_meeting_completed' => 0,
                'is_meeting_cancel' => 0
            ])->whereDate('date', '>=', date('Y-m-d'))->latest()->get();
        // return $rescheduleMeetings;
        return view('election.reschedule-meeting.index')->with([
            'agendas' => $agendas,
            'meetings' => $meetings,
            'departments' => $departments,
            'rescheduleMeetings' => $rescheduleMeetings
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            try {
                $check = ElectionScheduleMeeting::whereDate('date', date('Y-m-d', strtotime($request->date)))
                    ->where('time', date('H:i:s', strtotime($request->time)))
                    ->where('is_meeting_reschedule', '!=', 0)
                    ->where('election_meeting_id', $request->election_meeting_id)->exists();

                if ($check) {
                    return response()->json(['error' => 'Election meeting already created on date time ' . date('d-m-Y h:i A', strtotime($request->date . ' ' . $request->time)) . '. Please select diffrent datetime']);
                }


                DB::beginTransaction();
                try {

                    // get meeting Name
                    $meetingName = ElectionMeeting::where('id', $request->election_meeting_id)->value('name');

                    // get schedule meeting count
                    $count = ElectionScheduleMeeting::where('date', 'like', '%' . date('Y', strtotime($request->date)) . '%')->where('election_meeting_id', $request->election_meeting_id)->count();
                    $uniqueCount = $meetingName . ' क्र. ' . $count + 1;


                    $meeting = ElectionScheduleMeeting::find($request->election_schedule_meeting_id);

                    $request['parent_id'] = $meeting->parent_id;
                    $date = date('Y-m-d', strtotime($request->date));
                    $time = date('H:i:s', strtotime($request->time));
                    $request['election_agenda_id'] = $meeting->election_agenda_id;
                    $request['date'] = $date;
                    $request['time'] = $time;
                    $request['datetime'] = $date . " " . $time;

                    $request['unique_id'] = $uniqueCount;
                    $reScheduleMeeting = ElectionScheduleMeeting::create($request->all());


                    ElectionScheduleMeeting::where('id', $request->election_schedule_meeting_id)->update([
                        'is_meeting_reschedule' => 1
                    ]);

                    // logic to assign schedule meeting to department
                    if (isset($request->department_id)) {
                        for ($i = 0; $i < count($request->department_id); $i++) {
                            $assignScheduleMeetingDepartment = new ElectionAssignScheduleMeetingDepartment;
                            $assignScheduleMeetingDepartment->election_schedule_meeting_id = $reScheduleMeeting->id;
                            $assignScheduleMeetingDepartment->department_id = $request->department_id[$i];
                            $assignScheduleMeetingDepartment->save();
                        }
                    }
                    // end of logic to assign schedule meeting to department

                    // logic to send sms and email
                    // $members = ElectionAssignMemberToMeeting::with(['member'])->where('election_meeting_id', $request->election_meeting_id)->get();

                    // $scheduleMeeting = ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting'])->where('id', $request->schedule_meeting_id)->first();
                    // $rescheduleMeeting = ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting'])->where('id', $reScheduleMeeting->id)->first();

                    // foreach ($members as $member) {
                    //     Log::info('Sms Send to number' . $member->member->contact_number);
                    //     Mail::to($member->member->email)->send(new RescheduleMeetingMail($scheduleMeeting, $rescheduleMeeting));
                    // }
                    // end of send sms and email login

                    DB::commit();
                    return response()->json([
                        'success' => 'Election meeting reschedule successfully'
                    ]);
                } catch (\Exception $e) {
                    Log::info($e);
                    DB::rollback();
                    return response()->json([
                        'error' => 'Something went wrong'
                    ]);
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

                return response()->json(['success' => 'Election reschedule meeting cancel successfully!']);
            } catch (\Exception $e) {
                Log::info($e);
                DB::rollback();
                return response()->json(['error' => 'Something went wrong']);
            }
        }
    }

    public function show($id)
    {
        $rescheduleMeeting = ElectionScheduleMeeting::with(['electionAgenda', 'electionMeeting', 'assignScheduleMeetingDepartment.department'])->where('id', $id)->first();

        return view('election.reschedule-meeting.show')->with(['rescheduleMeeting' => $rescheduleMeeting]);
    }


    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $rescheduleMeetings = ElectionScheduleMeeting::where(['election_meeting_id' => $id, 'is_meeting_reschedule' => 0, 'is_meeting_completed' => 0, 'is_meeting_cancel' => 0])->select('id', 'datetime', 'unique_id')->get();

            $results = $rescheduleMeetings->map(function ($item, $key) {
                $item["unique_id"] =  $item["unique_id"] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'status' => 200,
                'data' => $results
            ]);
        }
    }

    public function getScheduleMeetingDetails(Request $request, $id)
    {
        if ($request->ajax()) {
            $rescheduleMeeting = ElectionScheduleMeeting::with(['electionMeeting', 'electionAgenda'])->where([
                'is_meeting_cancel' => 0,
                'is_meeting_completed' => 0
            ])->where('id', $id)->first();

            $result = [
                'agenda' => $rescheduleMeeting->electionAgenda?->subject,
                'meeting' => $rescheduleMeeting->electionMeeting?->name,
                'date' => date('d-m-Y', strtotime($rescheduleMeeting->date)),
                'time' => date('h:i A', strtotime($rescheduleMeeting->time)),
                'place' => $rescheduleMeeting->place,
            ];

            // to get department
            $departmentHtml = "";
            $value = "";
            $departments = ElectionAssignScheduleMeetingDepartment::with('department')->where('election_schedule_meeting_id', $id)->get();
            // $departments = $this->commonRepository->getDepartments();
            foreach ($departments as $department) {

                $departmentHtml .= '<input type="hidden" name="department_id[]" value="' . $department->department_id . '" />';
                $value .= $department->department->name . ", ";
            }
            $departmentHtml .= '<input type="text" value="' . $value . '" class="form-control" readonly />';

            return response()->json([
                'status' => 200,
                'data' => $result,
                'departments' => $departmentHtml
            ]);
        }
    }
}
