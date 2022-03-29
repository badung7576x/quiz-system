<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateClassRequest;
use App\Http\Requests\Admin\UpdateClassRequest;
use App\Services\ClassService;
use App\Models\Classes;
use App\Http\Traits\ResponseTrait;


class ClassController extends Controller
{
    use ResponseTrait;

    private $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = $this->classService->all();
        return view('admin.class.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClassRequest $request)
    {
        $data = $request->validated();
        try {
            $this->classService->create($data);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.class.create.error')));
        }

        return redirect()->route('admin.class.index')
            ->with($this->success(__('messages.class.create.success')));
    }

    /**
     * Display the specified resource.
     *
     * @param  Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $class)
    {
        $class->load('students');

        return view('admin.class.show', compact('class'));
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
     * @param  UpdateClassRequest  $request
     * @param  Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassRequest $request, Classes $class)
    {
        $data = $request->validated();
        try {
            $this->classService->update($class, $data);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.class.update.error')));
        }

        return redirect()->route('admin.class.index')
            ->with($this->success(__('messages.class.update.success')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class)
    {
        try {
            $this->classService->delete($class);
        } catch (\Exception $e) {
            return back()->with($this->error(__('messages.class.delete.error')));
        }

        return redirect()->route('admin.class.index')
            ->with($this->success(__('messages.class.delete.success')));
    }
}
