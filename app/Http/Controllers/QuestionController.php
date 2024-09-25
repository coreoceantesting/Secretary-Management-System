<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\QuestionRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\QuestionRequest;
use App\Models\Department;
use App\Models\Member;

class QuestionController extends Controller
{
    protected $questionRepository;
    protected $commonRepository;

    public function __construct(QuestionRepository $questionRepository, CommonRepository $commonRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $meetings = $this->commonRepository->getRescheduleMeeting();

        $questions = $this->questionRepository->index();

        $departments = Department::where('is_home_department', 0)->select('id', 'name')->get();

        $members = Member::select('id', 'name')->get();

        return view('question.index')->with([
            'questions' => $questions,
            'meetings' => $meetings,
            'departments' => $departments,
            'members' => $members,
        ]);
    }

    public function store(QuestionRequest $request)
    {
        $question = $this->questionRepository->store($request);

        if ($question) {
            return response()->json(['success' => 'Question created successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function edit($id)
    {
        $question = $this->questionRepository->edit($id);

        if ($question) {
            $scheduleMeetingHtml = '<label class="col-form-label" for="schedule_meeting_id">Select Schedule Meeting Date(शेड्यूल मीटिंग तारीख निवडा) <span class="text-danger">*</span></label>
            <select class="form-select col-sm-12" id="schedule_meeting_id1" name="schedule_meeting_id" required>
                <option value="">--Select Schedule Meeting--</option>';
            if ($question->schedule_meeting_id) {
                $scheduleMeetings = $this->questionRepository->getScheduleMeeting($question->meeting_id);

                foreach ($scheduleMeetings as $scheduleMeeting) :
                    $isSelected = $scheduleMeeting->id == $question->schedule_meeting_id ? 'selected' : '';
                    $scheduleMeetingHtml .= '<option ' . $isSelected . ' value="' . $scheduleMeeting->id . '">' . date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) . '</option>';
                endforeach;
            }
            $scheduleMeetingHtml .= '</select>
                                <span class="text-danger is-invalid schedule_meeting_id_err"></span>';

            // logic to get department
            // $departmentHtml = '<option value="">Select Department</option>';
            // $departments = $this->questionRepository->getScheduleMeetingDepartments($question->schedule_meeting_id, $id);

            // foreach ($departments as $department) {
            //     $isSelected = ($department->department?->id == $question->department_id) ? 'selected' : '';
            //     $departmentHtml .= '<option ' . $isSelected . ' value="' . $department->department?->id . '">' . $department->department?->name . '</option>';
            // }

            // sub question
            $count = 1;
            $subQuestionHtml = "";
            $subQuestions = $this->questionRepository->getSubQuestions($question->id);

            $members = Member::select('id', 'name')->get();

            foreach ($subQuestions as $subQuestion) {
                if ($count == "1") {
                    $subQuestionHtml .= "<tr id='editrow$count'>
                                <td>
                                    <textarea class='form-control' name='question[]' placeholder='Enter Question' required>" . $subQuestion->question . "</textarea>
                                </td>
                                <td>
                                    <select name='member_id[]' class='form-select' required>
                                        <option value=''>Select Member</option>";
                    foreach ($members as $member) {
                        $isSelected = ($member->id == $subQuestion->member_id) ? "selected" : "";
                        $subQuestionHtml .= "<option " . $isSelected . " value='" . $member->id . "'>" . $member->name . "</option>";
                    }
                    $subQuestionHtml .= "</select>
                                </td>
                                <td>
                                    <button type='button' class='btn btn-sm btn-primary editAddMore' data-id='" . $count . "'>Add</button>
                                </td>
                            </tr>";
                } else {
                    $subQuestionHtml .= "<tr id='editrow$count'>
                                <td>
                                    <textarea class='form-control' name='question[]' placeholder='Enter Question' required>" . $subQuestion->question . "</textarea>
                                </td>
                                <td>
                                    <select name='member_id[]' class='form-select' required>
                                        <option value=''>Select Member</option>";
                    foreach ($members as $member) {
                        $isSelected = ($member->id == $subQuestion->member_id) ? "selected" : "";
                        $subQuestionHtml .= "<option " . $isSelected . " value='" . $member->id . "'>" . $member->name . "</option>";
                    }
                    $subQuestionHtml .= "</select>
                                </td>
                                <td>
                                    <button type='button' class='btn btn-sm btn-danger editRemoveMore' data-id='" . $count . "'>Remove</button>
                                </td>
                            </tr>";
                }
                $count++;
            }

            $response = [
                'result' => 1,
                'question' => $question,
                'scheduleMeeting' => $scheduleMeetingHtml,
                'subQuestionHtml' => $subQuestionHtml,
                // 'departmentHtml' => $departmentHtml
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(QuestionRequest $request, $id)
    {
        $question = $this->questionRepository->update($request, $id);

        if ($question) {
            return response()->json(['success' => 'Question updated successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function destroy($id)
    {
        $question = $this->questionRepository->destroy($id);

        if ($question) {
            return response()->json(['success' => 'Schedule meeting deleted successfully!']);
        } else {
            return response()->json(['error' => 'Something went wrong please try again']);
        }
    }

    public function getScheduleMeeting(Request $request, $id)
    {
        if ($request->ajax()) {
            $scheduleMeetings = $this->questionRepository->getScheduleMeeting($id);

            $results = $scheduleMeetings->map(function ($item, $key) {
                $item["datetime"] =  $item['unique_id'] . ' (' . date('d-m-Y h:i A', strtotime($item["datetime"])) . ')';
                $item["id"] =  $item["id"];
                return $item;
            });

            return response()->json([
                'scheduleMeetings' => $results
            ]);
        }
    }

    public function show($id)
    {
        $question = $this->questionRepository->show($id);

        $subQuestions = $this->questionRepository->getSubQuestions($id);

        return view('question.show')->with([
            'question' => $question,
            'subQuestions' => $subQuestions
        ]);
    }

    public function response(Request $request)
    {
        $question = $this->questionRepository->response($request);

        if ($question) {
            return redirect()->route('question.index')->with(['success' => 'Schedule meeting deleted successfully!']);
        } else {
            return redirect()->route('question.index')->with(['error' => 'Something went wrong please try again']);
        }
    }

    public function saveSingleResponse(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $question = $this->questionRepository->saveSingleResponse($request);

            if ($question) {
                return response()->json(['success' => 'Question Response updated successfully!']);
            } else {
                return response()->json(['error' => 'Something went wrong please try again']);
            }
        }
    }

    // get schedule meeting assign departments
    public function getScheduleMeetingDepartments(Request $request, $id)
    {
        if ($request->ajax()) {
            $departments = $this->questionRepository->getScheduleMeetingDepartments($id, $request->type);

            return response()->json([
                'departments' => $departments
            ]);
        }
    }

    // accpet question by mayor
    public function acceptMayorQuetion(Request $request)
    {
        $data = $this->questionRepository->acceptMayorQuetion($request);

        return response()->json([
            'success' => "Question accepted successfully!"
        ]);
    }

    // send question to department
    public function sendQuestionToDepartment(Request $request)
    {
        $data = $this->questionRepository->sendQuestionToDepartment($request);

        return response()->json([
            'success' => "Question sended successfully!"
        ]);
    }
}
