<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $commonService;
    protected $subjectService;

    public function __construct(CommonService $commonService, SubjectService $subjectService)
    {
        $this->commonService = $commonService;
        $this->subjectService = $subjectService;
    }

    public function index(Request $request)
    {
        $summary = $this->commonService->getSummary();
        $teacherAnalysis = $this->commonService->getAnalysisTeacher();
        $questionBankAnalysis = $this->commonService->getAnalysisQuestionBank();
        $subject = $this->subjectService->subjectWithContents();


        return view('admin.dashboard.index', compact('summary', 'teacherAnalysis', 'questionBankAnalysis', 'subject'));
    }
}
