<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Services\QuestionService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use ResponseTrait;

    protected $questionService;
    protected $subjectService;

    public function __construct(QuestionService $questionService, SubjectService $subjectService)
    {
        $this->questionService = $questionService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionService->all();
        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subjectService->subjectWithContents();
        return view('admin.question.create', compact('subjects'));
    }

    public function renderForm(Request $request)
    {
        switch ($request->type) {
            case QUESTION_MULTI_CHOICE:
                $form = view('admin.question._multichoice')->render();
            // case QUESTION_SHORT_ANSWER:
            //     return view('admin.question.short-answer')->render();
            // case QUESTION_MATCHING:
            //     return view('admin.question.matching')->render();
            // case QUESTION_TRUE_FALSE:
            //     return view('admin.question.true-false')->render();
            default:
                $form = view('admin.question._multichoice')->render();
        }

        return response()->json(['html' => $form]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $data = $request->validated();
        try {
            $this->questionService->createQuestion($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('create');
        }

        return $this->redirectSuccess('admin.question.create', 'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $question->load('answers');
        $subjects = $this->subjectService->subjectWithContents();
        return view('admin.question.edit', compact('subjects', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionRequest $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->validated();
        try {
            $this->questionService->updateQuestion($question, $data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('update');
        }

        return $this->redirectSuccess('admin.question.index', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        try {
            $this->questionService->deleteQuestion($question);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('delete');
        }

        return $this->redirectSuccess('admin.question.index', 'delete');
    }
}
