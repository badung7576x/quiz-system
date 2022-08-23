@extends('layouts.admin')

@section('title', 'Soạn thảo câu hỏi')

@section('content')
		<form class="space-y-4" action="{{ route('admin.question.update', ['question' => $question->id]) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="content content-boxed">
						<div class="block-rounded block">
								<div class="block-header block-header-default">
										<h3 class="block-title">Chỉnh sửa câu hỏi</h3>
										<div class="block-options">
												<a href="{{ route('admin.question.index') }}" class="btn btn-sm btn-secondary">
														<i class="fa fa-arrow-left"></i> Quay lại
												</a>
												<button type="submit" class="btn btn-sm btn-success">
														<i class="fa fa-save"></i> Cập nhật
												</button>
										</div>
								</div>
								<div class="block-content block-content-full">
										<div class="row">
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Môn học</label>
																<div class="col-sm-12">
																		<select id="subject" class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
																				<option value="{{ $subject->id }}" @selected(old('subject_id', $question->subject_id) == $subject->id)>{{ $subject->name }}</option>
																		</select>
																		@error('subject_id')
																				<span class="text-danger">{{ $message }}</span>
																		@enderror
																</div>
														</div>
												</div>
												<div class="col-8">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Nội dung</label>
																<div class="col-sm-12">
																		<select id="subject-content" class="form-select @error('subject_content_id') is-invalid @enderror" name="subject_content_id">
																				<option value="">--Lựa chọn nội dung--</option>
																				@foreach ($subject->contents as $subjectContent)
																						<option value="{{ $subjectContent->id }}" @selected(old('subject_content_id', $question->subject_content_id) == $subjectContent->id)>{{ $subjectContent->name }}</option>
																				@endforeach
																		</select>
																		@error('subject_content_id')
																				<span class="text-danger">{{ $message }}</span>
																		@enderror
																</div>
														</div>
												</div>
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Mức độ câu hỏi</label>
																<div class="col-sm-12">
																		<select class="form-select" name="level">
																				@foreach (config('fixeddata.question_level') as $level => $label)
																						<option value="{{ $level }}" @selected(old('level', $question->level) == $level)>{{ $label }}</option>
																				@endforeach
																		</select>
																</div>
														</div>
												</div>
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Loại câu hỏi</label>
																<div class="col-sm-12">
																		<select id="question-type" class="form-select" disabled>
																				@foreach (config('fixeddata.question_type') as $type => $label)
																						<option value="{{ $type }}" @selected(old('level', $question->type) == $type)>{{ $label }}</option>
																				@endforeach
																		</select>
																		<input type="hidden" name="type" value="{{ $question->type }}">
																</div>
														</div>
												</div>
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Điểm</label>
																<div class="col-sm-12">
																		<input type="text" class="form-control" name="score" value="{{ old('score', $question->score) }}" placeholder="Nhập điểm">
																</div>
														</div>
												</div>
										</div>
								</div>
						</div>
				</div>
				<div class="content content-boxed" style="padding-top: 0; margin-top: 0">
						<div class="block-rounded block">
								<div class="block-header block-header-default">
										<h3 class="block-title">Trình soạn thảo</h3>
										<div class="block-options">

										</div>
								</div>
								<div class="block-content block-content-full">
										<div class="row" id="question-form">
												@switch($question->type)
														@case(QUESTION_MULTI_CHOICE)
																@include('admin.question._multichoice.edit')
														@break
														@case(QUESTION_SHORT_ANSWER)
															@include('admin.question._shortanswer.edit')
														@break
														@case(QUESTION_TRUE_FALSE)
																@include('admin.question._truefalse.edit')
														@break

														@default
												@endswitch
										</div>
								</div>
						</div>
				</div>
		</form>
@endsection

@section('css_before')

@endsection

@section('js_after')
		<script>
		  function showOldAnswer() {
		    const contentArea = document.getElementById('content-area');
		    let oldAnswer = @json(old('answers', $question->answers));
		    let oldCorrectAnswer = @json(old('correct_answer', []));
		    let newAnswer = @json(old('new_answers', []));
		    let newCorrectAnswer = @json(old('new_correct_answer', []));
        console.log(newCorrectAnswer)

		    const newErrorContent = @json($errors->get('new_answers.*'));

		    if (!Array.isArray(oldAnswer)) {
		      const oldErrorContent = @json($errors->get('answers.*'));

		      oldAnswer = Object.keys(oldAnswer).map(function(key) {
		        return {
		          id: key,
		          content_1: oldAnswer[key],
              is_correct:  oldCorrectAnswer[key],
		          error: oldErrorContent['answers.' + key]
		        };
		      });

		      newAnswer = newAnswer.map(function(key, index) {
            console.log(index+oldAnswer.length+99999)
		        return {
		          id: index,
		          content_1: key,
              is_correct: newCorrectAnswer[index+oldAnswer.length+9999],
		          error: newErrorContent['new_answers.' + index] ? newErrorContent['new_answers.' + index][0] : ''
		        };
		      });
		    }
        console.log(oldAnswer, newAnswer)

		    oldAnswer && oldAnswer.forEach(function(content, index) {
		      if (index != 0) addContent(content);
		    });

		    newAnswer && newAnswer.forEach(function(content, index) {
		      addNewContent(content);
		    });

		  }

		  $(document).ready(function() {
		    showOldAnswer();
		  });
		</script>
@endsection
