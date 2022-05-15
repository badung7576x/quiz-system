<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionSetRequest;
use App\Services\QuestionSetService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\QuestionSet;
use Illuminate\Support\Facades\DB;

class QuestionSetController extends Controller
{
    use ResponseTrait;

    protected $questionSetService;
    protected $subjectService;

    public function __construct(QuestionSetService $questionSetService, SubjectService $subjectService)
    {
        $this->questionSetService = $questionSetService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionSets = $this->questionSetService->all();
        $subjects = $this->subjectService->all();

        return view('admin.question_set.index', compact('questionSets', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subjectService->all();

        return view('admin.question_set.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionSetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionSetRequest $request)
    {
        $data = $request->validated();
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
     * @param  QuestionSet  $questionSet
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionSet $questionSet)
    {
        try {
            $this->questionSetService->delete($questionSet);
        } catch (\Throwable $e) {
            return back()->with($this->error($e->getMessage()));
        }

        return redirect()->route('admin.question-set.index')
            ->with($this->success(__('messages.delete.success')));
    }
}
