<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Services\QuestionService;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

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
            \Log::error($e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
