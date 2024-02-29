<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\QuestionRepository;
use App\Repository\CommonRepository;

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
        $meetings = $this->commonRepository->getSeventDayMeeting();

        $questions = $this->questionRepository->index();

        return view('question.index')->with([
            'questions' => $questions,
            'meetings' => $meetings
        ]);
    }

    public function store(Request $request)
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
            $scheduleMeetingHtml = '<label class="col-form-label" for="schedule_meeting_id">Select Schedule Meeting Date <span class="text-danger">*</span></label>
            <select class="form-select col-sm-12" id="schedule_meeting_id" name="schedule_meeting_id">
                <option value="">--Select Schedule Meeting--</option>';
            if ($question->schedule_meeting_id) {
                $scheduleMeetings = $this->questionRepository->getScheduleMeeting($id);
                foreach ($scheduleMeetings as $scheduleMeeting) :
                    $isSelected = $scheduleMeeting->id == $question->schedule_meeting_id ? 'selected' : '';
                    $scheduleMeetingHtml .= '<option ' . $isSelected . ' value="' . $scheduleMeeting->id . '">' . $scheduleMeeting->date . '</option>';
                endforeach;
            }
            $scheduleMeetingHtml .= `</select>
                                <span class="text-danger is-invalid schedule_meeting_id_err"></span>`;

            $response = [
                'result' => 1,
                'question' => $question,
                'scheduleMeeting' => $scheduleMeetingHtml
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(Request $request, $id)
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

            return response()->json([
                'scheduleMeetings' => $scheduleMeetings
            ]);
        }
    }

    public function show($id)
    {
        $question = $this->questionRepository->show($id);

        return view('question.show')->with([
            'question' => $question
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
}
