<?php 
namespace App\Services;

use App\Models\Subject;
use App\Models\SubjectContent;
use Illuminate\Support\Facades\DB;

class SubjectService
{

  public function all()
  {
    $user = auth()->user();
    if($user->role == ROLE_ADMIN) {
      return Subject::with('contents')->latest()->get();
    } else {
      return Subject::with('contents')->where('id', $user->subject_id)->latest()->get();
    }
  }

  public function subjectWithContents()
  {
    $user = auth()->user();
    return Subject::with('contents')->find($user->subject_id);
  }

  public function getSubjectContents()
  {
    $user = auth()->user();
    $subjectContents = SubjectContent::whereSubjectId($user->subject->id)->latest()->get();
    return $subjectContents;
  }

  public function create(array $data)
  {
    $oldSubject = Subject::whereName($data['name'])->first();
    if($oldSubject) {
      throw new \Exception('Môn học đã tồn tại trên hệ thống.');
    } else {
      DB::beginTransaction();
      try {
        $subject = Subject::create($data);
    
        $subjectContents = [];
        $contentData = array_unique($data['subject_contents']);
        foreach ($contentData as $index => $each) {
          $subjectContents[] = [
            'order' => $index + 1,
            'name' => $each
          ];
        }
        $subject->contents()->createMany($subjectContents);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollBack();
      }
    }
  }

  public function update(Subject $subject, array $data)
  {
    $subject->update($data);
    DB::beginTransaction();
      try {
        $subject = Subject::create($data);
    
        $subjectContents = [];
        $contentData = array_unique($data['subject_contents']);
        foreach ($contentData as $each) {
          $subjectContents[] = [
            'name' => $each
          ];
        }
        $subject->contents()->createMany($subjectContents);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollBack();
      }
  }

  public function delete(Subject $subject)
  {
    $subject->delete();
  }
}
