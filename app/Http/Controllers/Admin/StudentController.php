<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateStudentRequest;
use App\Http\Requests\Admin\StudentImportRequest;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Services\FileService;
use App\Http\Traits\ResponseTrait;
use App\Models\Student;
use App\Services\StudentService;

class StudentController extends Controller
{
    use ResponseTrait;

    protected $fileService;
    protected $studentService;

    public function __construct(FileService $fileService, StudentService $studentService)
    {
        $this->fileService = $fileService;
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Classes $class)
    {
        return view('admin.student.create', compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Classes $class, CreateStudentRequest $request)
    {
        $data = $request->validated();

        try {
            $this->studentService->create($class, $data);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.student.create.error')));
        }

        return redirect()->route('admin.class.show', $class->id)
            ->with($this->success(__('messages.student.create.success')));
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
    public function edit(Classes $class, Student $student)
    {
        return view('admin.student.edit', compact('class', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateStudentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Classes $class, Student $student, CreateStudentRequest $request)
    {
        $data = $request->validated();
        try {
            $this->studentService->update($student, $data);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.student.update.error')));
        }

        return redirect()->route('admin.class.show', $class->id)
            ->with($this->success(__('messages.student.update.success')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class, Student $student)
    {
        try {
            $this->studentService->delete($student);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.student.delete.error')));
        }

        return redirect()->route('admin.class.show', $student->class_id)
            ->with($this->success(__('messages.student.delete.success')));
    }

    public function importExcel(Classes $class, StudentImportRequest $request)
    {
        $file = $request->file('import_file');
        $request->offsetUnset('import_file');

        try {
            $this->fileService->importStudent($class, $file);
        } catch (\Throwable $e) {
            return back()->with($this->error($e->getMessage()));
        }

        return redirect()->route('admin.class.show', $class->id)
            ->with($this->success(__('messages.student.import.success')));
    }
}
