<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamSetRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\ExamSet;
use App\Services\ExamSetService;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class ExamSetController extends Controller
{
    use ResponseTrait;

    protected $examSetService;

    public function __construct(ExamSetService $examSetService, SubjectService $subjectService)
    {
        $this->examSetService = $examSetService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examSets = $this->examSetService->all();
        return view('admin.exam-set.index', compact('examSets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subjectService->subjectWithContents();
        return view('admin.exam-set.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamSetRequest $request)
    {
        $data = $request->validated();
        $this->examSetService->create($data);

        return $this->redirectSuccess('admin.exam-set.index', 'create');
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

    public function export(ExamSet $examSet)
    {
        $this->examSetService->exportExamSetFile($examSet);

        return $this->redirectSuccess('admin.exam-set.index', 'export');
    }

    public function import(ExamSet $examSet)
    {
        $this->examSetService->importExamSetFile($examSet);

        return $this->redirectSuccess('admin.exam-set.index', 'import');
    }
}
