<?php

namespace App\Services;

use App\Models\ExamSet;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;

class ExamSetService
{

  public function all()
  {
    $user = auth()->user();
    return ExamSet::where('created_by', $user->id)->latest()->get();
  }

  public function create($data)
  {
    DB::beginTransaction();
    try {
      $examSet = ExamSet::create($data);
      $numOfQuestions = $data['total_question'];

      $questionIds = Question::inRandomOrder()
        ->whereIn('subject_content_id', $data['subject_content_ids'])
        ->limit($numOfQuestions)->pluck('id')->toArray();

      $questionIdsWithOrder = [];
      foreach ($questionIds as $key => $questionId) {
        $questionIdsWithOrder[$questionId] = ['order' => $key + 1];
      }

      $examSet->questions()->attach($questionIdsWithOrder);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  public function exportExamSetFile($examSet)
  {
    $examSet->load('subject', 'questions', 'questions.answers');
    dd($examSet);

    $ss = IOFactory::load(storage_path('app/templates/PHIEU_BAI_THI.xlsx'));

    $sheet = $ss->getSheetByName('TEMPLATE_01');
    $leftTopText = "SỞ GIÁO DỤC VÀ ĐÀO TẠO HÀ NỘI";
    $sheet->getCell('B2')->setValue($leftTopText);
    $sheet->getStyle('B2')->getFont()->setSize(22);
    $sheet->getStyle('U2')->getFont()->setSize(22);
    $sheet->getStyle('A8')->getFont()->setSize(24);
    $sheet->getCell('A10')->setValue('MÔN THI: ' . $examSet->subject->name);
    $sheet->getCell('A11')->setValue('NGÀY THI: ' . Carbon::now()->format('d/m/Y'));
    $sheet->getStyle('A10')->getFont()->setSize(23);
    $sheet->getStyle('A11')->getFont()->setSize(23);

    $sheet->getCell('L14')->setValue("");
    $sheet->getStyle('A14:AM14')->getFont()->setSize(22);

    $sheet->getCell('J15')->setValue("");
    $sheet->getStyle('A15:AM15')->getFont()->setSize(22);

    $sheet->getCell('K17')->setValue("");
    $sheet->getCell('T17')->setValue("");
    $sheet->getCell('AD17')->setValue("");
    $sheet->getStyle('A17:AM17')->getFont()->setSize(22);
    $sheet->getStyle('A19:AM19')->getFont()->setSize(22);

    $questions = $examSet->questions;
    $startRow = 21;

    foreach ($questions as $qIdx => $question) {
      $questionIdx = strval($startRow + $qIdx * 7);

      $sheet->mergeCells('D' . $questionIdx . ':F' . $questionIdx);
      $sheet->getCell('D' . $questionIdx)->setValue('Câu ' . strval($qIdx + 1) . ':');
      $sheet->mergeCells('G' . $questionIdx . ':AJ' . $questionIdx);
      $sheet->getCell('G' . $questionIdx)->setValue($question->content);
      $sheet->getStyle('A' . $questionIdx . ':AM' . $questionIdx)->getFont()->setSize(22)->setBold(true)->setItalic(false);
      $sheet->getStyle('A' . $questionIdx . ':AM' . $questionIdx)->getAlignment()->setVertical('top');

      for ($idx = 1; $idx < 5; $idx++) {
        $answerIdx = $questionIdx + $idx + 1;
        $answerField = 'answer_' . $idx;
        $sheet->mergeCells('D' . $answerIdx . ':F' . $answerIdx);

        $sheet->getStyle('D' . $answerIdx . ':F' . $answerIdx)->getFont()->setSize(22)->setBold(true);

        $sheet->mergeCells('G' . $answerIdx . ':AJ' . $answerIdx);
        $answerString = config('mapping.answer')[$idx] . ". " . $question->$answerField . ($question->correct_answer == $idx ? ' (*)' : '');
        $sheet->getCell('G' . $answerIdx)->setValue($answerString);
        $sheet->getStyle('G' . $answerIdx . ':AM' . $answerIdx)->getFont()->setSize(22)->setBold(false)->setItalic(true);
        $sheet->getStyle('A' . $answerIdx . ':AM' . $answerIdx)->getAlignment()->setVertical('middle');
      }
      $sheet->getRowDimension($questionIdx + 6)->setRowHeight('15px');
    }

    $fileName = 'PHIEU_DE_THI';
    $ss->getProperties()->setTitle($fileName);
    $pdfFilePath = storage_path('app/downloads/' . $fileName  . '.pdf');
    $writer = IOFactory::createWriter($ss, 'Mpdf');
    $writer->save($pdfFilePath);

    if (File::exists($pdfFilePath)) {
      return $pdfFilePath;
    } else {
      throw new \RuntimeException('Không thể lưu file ' . $pdfFilePath);
    }
  }
}
