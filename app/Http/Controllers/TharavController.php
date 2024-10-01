<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TharavRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\TharavRequest;
use App\Models\AssignDepartmentToTharav;
use App\Models\TharavQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TharavController extends Controller
{
    protected $tharavRepository;
    protected $commonRepository;

    public function __construct(TharavRepository $tharavRepository, CommonRepository $commonRepository)
    {
        $this->tharavRepository = $tharavRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $tharavs  = $this->tharavRepository->index();

        $meetings = $this->commonRepository->getGeneratedProceedingRecordMeeting();

        return view('tharav.index')->with([
            'tharavs' => $tharavs,
            'meetings' => $meetings
        ]);
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->tharavRepository->getScheduleMeeting($id);

            $results = $scheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  $item['unique_id'] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'scheduleMeetings' => $scheduleMeetings
            ]);
        }
    }

    public function getScheduleMeetingDepartment(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->tharavRepository->getScheduleMeetingDepartment($id);
            $departmentHtml = "";

            $departmentHtml .= '<option value="" disabled>Select Department</option>';
            foreach ($scheduleMeetings as $scheduleMeeting) {
                $departmentHtml .= '<option value="' . $scheduleMeeting->department_id . '">' . $scheduleMeeting->department?->name . '</option>';
            }

            return response()->json([
                'status' => 200,
                'department' => $departmentHtml
            ]);
        }
    }

    public function store(TharavRequest $request)
    {
        $tharavRepository = $this->tharavRepository->store($request);

        if ($tharavRepository) {
            return response()->json(['success' => 'Tharav created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function getTharavDepartment(Request $request)
    {
        if ($request->ajax()) {
            $departments = AssignDepartmentToTharav::where('tharav_id', $request->id)->with('department')->get();

            $departmentHtml = "";

            $departmentHtml .= '<option value="">Select Department</option>';
            foreach ($departments as $department) {
                $departmentHtml .= '<option value="' . $department?->department?->id . '">' . $department->department?->name . '</option>';
            }

            return response()->json([
                'status' => 200,
                'department' => $departmentHtml
            ]);
        };
    }

    public function saveDepartmentQuestion(Request $request)
    {
        if ($request->ajax()) {
            $request['question_by'] = Auth::user()->id;
            $request['question_time'] = now();
            $tharavQuestion = TharavQuestion::create($request->all());

            if ($tharavQuestion) {
                return response()->json(['success' => 'Tharav question created successfully!']);
            } else {
                return response()->json(['error' => 'Something went wrong please try again']);
            }
        }
    }

    public function getTharavDepartmentQuestion(Request $request, $id)
    {
        if ($request->ajax()) {
            $questions = TharavQuestion::where('tharav_id', $id)->when(Auth::user()->hasRole('Department'), function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            })->with('department')->get();

            $html = "";

            foreach ($questions as $question) {
                $html .= '
                    <tr>
                        <td><input type="hidden" name="id[]" value="' . $question->id . '" >' . $question?->department?->name . '</td>
                        <td>' . $question->question . '</td>
                        <td>' . (($question->answer == "" && Auth::user()->hasRole('Department')) ? '<textarea name="answer[]" class="form-control"></textarea>' : (($question->answer && $question->answer != "") ? $question->answer : '-')) . '</td>
                    </tr>
                ';
            }

            return response()->json([
                'status' => 200,
                'question' => $html
            ]);
        }
    }


    public function saveDepartmentQuestionResponse(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                if (isset($request->id) && count($request->id) > 0) {
                    for ($i = 0; $i < count($request->id); $i++) {
                        if (isset($request->answer[$i]) && $request->answer[$i] != "") {
                            $tharavQuestion = TharavQuestion::find($request->id[$i]);
                            $tharavQuestion->answer = $request->answer[$i];
                            $tharavQuestion->answer_by = Auth::user()->id;
                            $tharavQuestion->answer_time = now();
                            $tharavQuestion->save();
                        }
                    }
                }
                DB::commit();
                return response()->json(['success' => 'Answer save successfully']);
            } catch (\Exception $e) {
                \Log::info($e);
                return response()->json(['error' => 'Something went wrong please try again']);
            }
        }
    }
}
