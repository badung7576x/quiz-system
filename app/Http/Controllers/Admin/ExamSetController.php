<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamSetRequest;
use App\Http\Requests\Admin\ExamSetSettingRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\ExamSet;
use App\Services\ExamSetService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use PDF;

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
        $subjectContents = $this->subjectService->getSubjectContents();
        return view('admin.exam-set.create', compact('subjectContents'));
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
    public function show(ExamSet $examSet)
    {
        $examSet->load('subject');
        return view('admin.exam-set.show', compact('examSet'));
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

    public function pdf(ExamSet $examSet)
    {
        $examSet = $this->examSetService->formatData($examSet);
        // dd($examSet);

        return view('admin.exam-set.template', compact('examSet'));
    }

    public function setting(ExamSet $examSet)
    {
        $examSet->load('setting');

        return view('admin.exam-set.setting', compact('examSet'));
    }

    public function saveSetting(ExamSet $examSet, ExamSetSettingRequest $request)
    {
        $data = $request->validated();

        $this->examSetService->saveSetting($examSet, $data);
        
        return $this->redirectSuccess('admin.exam-set.show', 'save', ['exam_set' => $examSet->id]);
    }

    public function download(ExamSet $examSet)
    {
        $data['examSet'] = $this->examSetService->formatData($examSet);
        $pdf = PDF::loadView('admin.exam-set.template_for_download', $data);

        return $pdf->stream();
    }
}
