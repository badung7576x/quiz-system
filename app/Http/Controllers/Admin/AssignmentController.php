<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Services\QuestionService;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use ResponseTrait;

    protected $questionService;
    protected $teacherService;

    public function __construct(QuestionService $questionService, TeacherService $teacherService)
    {
        $this->questionService = $questionService;
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getSpecialTeachers();
        $questions = $this->questionService->getNonAssignQuestions();
        return view('admin.assignment.index', compact('questions', 'teachers'));
    }

    public function assign(Request $request)
    {
        $questionIds = $request->get('questions');
        $reviewTeacher = $request->get('teacher_id');
        $this->questionService->assign($questionIds, $reviewTeacher);
        return redirect()->back()->with('success', 'Câu hỏi đã được gán cho giáo viên');
    }
}
