<?php

namespace App\Services;

use App\Models\ExamSet;
use App\Models\ExamSetDetail;
use App\Models\Question;
use App\Models\QuestionBank;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Style\Paper;

class ExamSetService
{

  public function all()
  {
    $user = auth()->user();
    return ExamSet::where('created_by', $user->id)->latest()->get();
  }

  public function create($data)
  {
    $user = auth()->user();
    DB::beginTransaction();
    try {
      $numOfSet = $data['num_of_set'];
      $examSet = ExamSet::create($data);

      $numOfQuestions = $data['total_question'];
      $totalQuestionCount = QuestionBank::where('subject_id', $user->subject_id)->count();

      if ($totalQuestionCount < $numOfQuestions * GENERATE_RATIO) {
        throw new Exception('Số lượng câu hỏi trong ngân hàng đề không đủ');
      }

      $numOfDifficult = floor($numOfQuestions * 0.2);
      $difficultQuestionIds = QuestionBank::inRandomOrder()
        ->whereIn('subject_content_id', $data['subject_content_ids'])
        ->where('level', LEVEL_3)
        ->orderBy('level', 'desc')
        ->limit($numOfDifficult)->pluck('id')->toArray();

      $normalQuestionIds = QuestionBank::inRandomOrder()
        ->whereIn('subject_content_id', $data['subject_content_ids'])
        ->whereIn('level', [LEVEL_1, LEVEL_2])
        ->orderBy('level', 'desc')
        ->limit($numOfQuestions - $numOfDifficult)->pluck('id')->toArray();
      
      $questionIds = array_merge($normalQuestionIds, $difficultQuestionIds);

      if (count($questionIds) < $numOfQuestions) {
        throw new Exception('Số lượng câu hỏi trong ngân hàng đề không đủ');
      }

      $questionMap = [];
      foreach ($questionIds as $level => $questionId) {
        $questionMap[] = [
          'question_id' => $questionId
        ];
      }

      $examSet->questions()->attach($questionMap);

      for($i = 1; $i <= $numOfSet; $i++) {
        $randomOrder = $this->_generateRandomQuestion($normalQuestionIds, $difficultQuestionIds);

        $examSet->examSetDetails()->create([
          'code' => $data['code'] . str_pad($i, 3, "0", STR_PAD_LEFT),
          'question_order' => $randomOrder,
          'answers' => ''
        ]);
      }
      
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  public function formatData(ExamSet $examSet, ExamSetDetail $examSetDetail)
  {
    $examSet->load('subject', 'questions', 'questions.answers', 'setting');

    $questions = collect($examSet->questions)->map(function($question) {
      $ques = [
        'id' => $question->id,
        'content' => $question->content,
        'level' => $question->level
      ];

      $maxLength = 0;
      $correct = 0;
      foreach ($question->answers as $idx => $answer) {
        $maxLength = max($maxLength, strlen($answer->content_1));
        $ques['answers'][] = [
          'content' => $answer->content_1,
        ];
        if ($answer->is_correct) $correct =  $idx + 1;
      }

      $ques['correct_answer'] = $correct;
      $ques['length_answer'] = $maxLength;

      if ($maxLength < 50) {
        $ques['format'] = 'col-3';
      } else if ($maxLength < 100) {
        $ques['format'] = 'col-6';
      } else {
        $ques['format'] = 'col-12';
      }

      return (object) $ques;
    });

    // sort here
    $order = explode("_", $examSetDetail->question_order);
    $questions = $questions->sortBy(function($model) use ($order){
      return array_search($model->id, $order);
    });

    $examSet->questions = $questions;

    return $examSet;
  }

  public function saveSetting(ExamSet $examSet, array $data)
  {
    $examSet->setting()->updateOrCreate(['exam_set_id' => $examSet->id], $data);
  }

  public function delete(ExamSet $examSet)
  {
    return $examSet->delete();
  }

  public function downloadWord(ExamSet $examSet, ExamSetDetail $examSetDetail)
  {
    $phpWord = new PhpWord();
    
    $paper = new Paper();
    $paper->setSize('A4'); 
    $width = $paper->getWidth();

    $sectionStyle = array(
      'pageSizeW' => $paper->getWidth(), 
      'pageSizeH' => $paper->getHeight(), 
      'pageNumberingStart' => 1
    );

    $section = $phpWord->addSection($sectionStyle);

    $table = $section->addTable();
    $table->addRow();
    $table->addCell($width * 0.5)->addText("Top Left Content");
    $table->addCell($width * 0.5)->addText("Top Right Content");

    $table->addRow();
    $table->addCell($width)->addText("DDeef thi");


    $footer = $section->addFooter();
    $footer->addPreserveText('Trang {PAGE}/{NUMPAGES}', ['align' => 'center']);
    
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $filePath = storage_path('app/downloads/test.docx');
    $objWriter->save($filePath);

    if (File::exists($filePath)) {
        return $filePath;
    } else {
        throw new \RuntimeException('Không thể lưu file ' . $filePath);
    }
    return response()->download($filePath);
  }

  private function _generateRandomQuestion(array $normalIds, array $diffIds) {
    shuffle($normalIds);
    shuffle($diffIds);
    $listIds = array_merge($normalIds, $diffIds);

    return implode('_', $listIds);
  }
}
