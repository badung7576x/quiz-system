<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportQuestionRequest;
use App\Http\Requests\Admin\QuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Services\QuestionService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\Question;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use ResponseTrait;

    protected $questionService;
    protected $subjectService;
    protected $fileService;

    public function __construct(QuestionService $questionService, SubjectService $subjectService, FileService $fileService)
    {
        $this->questionService = $questionService;
        $this->subjectService = $subjectService;
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionService->allMyQuestions();
        return view('admin.question.index', compact('questions'));
    }

    public function reviews()
    {
        $questions = $this->questionService->allReviewQuestions();
        
        return view('admin.question.reviews', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subject = $this->subjectService->subjectWithContents();
        return view('admin.question.create', compact('subject'));
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
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->load(['answers', 'subject', 'subject_content']);
        $comments = $this->questionService->getAllCommentForQuestion($question);

        return view('admin.question.show', compact('question', 'comments'));
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function reviewShow(Question $question)
    {
        $question->load(['answers', 'subject', 'subject_content']);
        $comments = $this->questionService->getAllCommentForQuestion($question);

        return view('admin.question.review_show', compact('question', 'comments'));
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
        if ($question->status >= QUESTION_STATUS_REVIEWED) {
            abort(404);
        }
        $subject = $this->subjectService->subjectWithContents();
        return view('admin.question.edit', compact('subject', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionRequest $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
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

    public function review(Question $question, Request $request)
    {
        try {
            $this->questionService->reviewQuestion($question, $request->status);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('review');
        }

        return $this->redirectBackWithSuccess('review');
    }

    public function import(ImportQuestionRequest $request)
    {
        $file = $request->file('question_file');
        $request->offsetUnset('question_file');

        DB::beginTransaction();
        try {
            $this->fileService->importQuestions($file);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->redirectError('import');
        }
        
        
        return $this->redirectSuccess('admin.question.index', 'import');
    }

    /**
     * Get template content of question bank
     *
     * @param QuestionBank $question
     * @return \Illuminate\Http\Response
     */
    public function contentTemplate($id)
    {
        $question = $this->questionService->findQuestion($id);

        $html = view('admin.question._question-template', compact('question'))->render();
        
        return response()->json(['html' => $html]);
    }
}
