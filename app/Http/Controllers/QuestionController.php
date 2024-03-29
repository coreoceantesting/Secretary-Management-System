<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\QuestionRepository;
use App\Repository\CommonRepository;
use App\Http\Requests\QuestionRequest;

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

        $departments = $this->commonRepository->getDepartments();

        return view('question.index')->with([
            'questions' => $questions,
            'meetings' => $meetings,
            'departments' => $departments
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
            <select class="form-select col-sm-12" id="schedule_meeting_id" name="schedule_meeting_id" required>
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

            // sub question
            $count = 1;
            $subQuestionHtml = "";
            $subQuestions = $this->questionRepository->getSubQuestions($question->id);

            foreach ($subQuestions as $subQuestion) {
                if ($count == "1") {
                    $subQuestionHtml .= "<tr id='editrow$count'>
                                <td>
                                    <input class='form-control' name='question[]' value='" . $subQuestion->question . "' type='text' placeholder='Enter Question' required>
                                </td>
                                <td>
                                    <button type='button' class='btn btn-sm btn-primary editAddMore' data-id='" . $count . "'>Add</button>
                                </td>
                            </tr>";
                } else {
                    $subQuestionHtml .= "<tr id='editrow$count'>
                                <td>
                                    <input class='form-control' name='question[]' value='" . $subQuestion->question . "' type='text' placeholder='Enter Question' required>
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
                'subQuestionHtml' => $subQuestionHtml
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
                $item["datetime"] =  date('d-m-Y h:i A', strtotime($item["datetime"]));
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
}
