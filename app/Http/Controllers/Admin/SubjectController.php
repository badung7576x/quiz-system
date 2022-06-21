<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    use ResponseTrait;

    private $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjectService->all();
        return view('admin.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('is_admin')) {
            abort(404);
        }

        return view('admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(404);
        }

        $data = $request->validated();
        try {
            $this->subjectService->create($data);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->redirectError('create', $message);
        }

        return $this->redirectSuccess('admin.subject.index', 'create');
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
    public function edit(Subject $subject)
    {
        if (!Gate::allows('can-access', $subject)) {
            abort(404);
        }

        return view('admin.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubjectRequest  $request
     * @param  Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $data = $request->validated();
        try {
            $this->subjectService->update($subject, $data);
        } catch (\Exception $e) {
            return $this->redirectError('update');
        }

        return $this->redirectSuccess('admin.subject.index', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (!Gate::allows('is_admin')) {
            abort(403);
        }

        try {
            $this->subjectService->delete($subject);
        } catch (\Exception $e) {
            return $this->redirectError('delete');
        }

        return $this->redirectSuccess('admin.subject.index', 'delete');
    }
}
