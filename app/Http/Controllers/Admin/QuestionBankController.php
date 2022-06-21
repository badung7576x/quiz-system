<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\QuestionBank;
use App\Services\QuestionBankService;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Log;

class QuestionBankController extends Controller
{
    use ResponseTrait;

    protected $questionBankService;
    protected $subjectService;

    public function __construct(QuestionBankService $questionBankService, SubjectService $subjectService)
    {
        $this->questionBankService = $questionBankService;
        $this->subjectService = $subjectService;
    }

    public function index()
    {
        $questions = $this->questionBankService->getQuestionBank();
        
        return view('admin.banks.index', compact('questions'));
    }

    public function waitAccepts(Request $request)
    {
        $questions = $this->questionBankService->allWaitingAcceptQuestions();
        
        return view('admin.banks.accepts', compact('questions'));
    }

    /**
     * Get template content of question bank
     *
     * @param QuestionBank $question
     * @return \Illuminate\Http\Response
     */
    public function contentTemplate($id)
    {
        $question = $this->questionBankService->findQuestion($id);

        $html = view('admin.banks._question-template', compact('question'))->render();
        
        return response()->json(['html' => $html]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = QuestionBank::find($id);
        try {
            $this->questionBankService->deleteQuestion($question);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->redirectError('delete');
        }

        return $this->redirectSuccess('admin.question-bank.index', 'delete');
    }
    
}
