<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use App\Services\TeacherService;
use App\Http\Traits\ResponseTrait;
use App\Models\Teacher;
use App\Services\CommonService;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    use ResponseTrait;

    protected $teacherService;
    protected $subjectService;
    protected $commonService;

    public function __construct(TeacherService $teacherService, SubjectService $subjectService, CommonService $commonService)
    {
        $this->teacherService = $teacherService;
        $this->subjectService = $subjectService;
        $this->commonService = $commonService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = $this->teacherService->allTeacherBySubject();

        return view('admin.teacher.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subjectService->all();
        $roles = $this->commonService->getRoles();
        return view('admin.teacher.create', compact('subjects', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        $data = $request->validated();

        try {
            $this->teacherService->create($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('create');
        }

        return $this->redirectSuccess('admin.teacher.index', 'create');
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
    public function edit(Teacher $teacher)
    {
        if (!Gate::allows('can-access', $teacher)) {
            abort(403);
        }

        $subjects = $this->subjectService->all();
        $roles = $this->commonService->getRoles();
        return view('admin.teacher.edit', compact('teacher', 'subjects', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $data = $request->validated();
        try {
            $this->teacherService->update($teacher, $data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('update');
        }

        return $this->redirectSuccess('admin.teacher.index', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $this->teacherService->delete($teacher);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('delete');
        }

        return $this->redirectSuccess('admin.teacher.index', 'delete');
    }
}
