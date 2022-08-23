@extends('layouts.admin')

@section('title', 'Soạn thảo câu hỏi')

@section('content')
		<form id="create_question" class="space-y-4" action="{{ route('admin.question.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="content content-boxed">
						<div class="block-rounded block">
								<div class="block-header block-header-default">
										<h3 class="block-title">Tạo câu hỏi</h3>
										<div class="block-options">
												<a href="{{ route('admin.question.index') }}" class="btn btn-sm btn-secondary">
														<i class="fa fa-arrow-left"></i> Quay lại
												</a>
												<button type="submit" class="btn btn-sm btn-success">
														<i class="fa fa-save"></i> Tạo mới
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
																				<option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
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
																				@foreach ($subject->contents as $subjectContent)
																						<option value="{{ $subjectContent->id }}" @selected(old('subject_content_id') == $subjectContent->id)>{{ $subjectContent->name }}</option>
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
																						<option value="{{ $level }}" @selected(old('level') == $level)>{{ $label }}</option>
																				@endforeach
																		</select>
																</div>
														</div>
												</div>
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Loại câu hỏi</label>
																<div class="col-sm-12">
																		<select id="question-type" class="form-select" name="type">
																				@foreach (config('fixeddata.question_type') as $type => $label)
																						<option value="{{ $type }}" @selected(old('type', request()->type) == $type)>{{ $label }}</option>
																				@endforeach
																		</select>
																</div>
														</div>
												</div>
												<div class="col-4">
														<div class="row mb-3">
																<label class="col-sm-12 col-form-label">Điểm</label>
																<div class="col-sm-12">
																		<input type="text" class="form-control" name="score" value="{{ old('score', 1) }}" placeholder="Nhập điểm">
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
												@switch(request()->type)
														@case(QUESTION_MULTI_CHOICE)
																@include('admin.question._multichoice.create')
														@break
														@case(QUESTION_SHORT_ANSWER)
																@include('admin.question._shortanswer.create')
														@break
														@case(QUESTION_TRUE_FALSE)
																@include('admin.question._truefalse.create')
														@break

														@default
																@include('admin.question._multichoice.create')
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
		<script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
		<script>
		  const subjects = [];
		  $(document).ready(function() {
		    changeQuestionType()
		    renderOldValue()
		  });

		  function initCkeditor() {
		    $(".ckeditor1").each(function(_, ckeditor) {
		      CKEDITOR.replace(ckeditor, {
		        toolbar: [{
		            name: 'clipboard',
		            items: ['Undo', 'Redo']
		          },
		          {
		            name: 'basicstyles',
		            items: ['Bold', 'Italic', 'Underline', 'Strike', 'CopyFormatting', 'RemoveFormat']
		          },
		          {
		            name: 'paragraph',
		            items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
		          },
		          {
		            name: 'links',
		            items: ['Link', 'Unlink']
		          },
		          {
		            name: 'insert',
		            items: ['Image', 'Table', 'Mathjax']
		          },
		          {
		            name: 'colors',
		            items: ['TextColor', 'BGColor']
		          },
		          {
		            name: 'tools',
		            items: ['Maximize']
		          },
		        ],
		        extraPlugins: 'mathjax',
		        mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
		        removeButtons: 'PasteFromWord'
		      })
		    });
		  }

		  function changeQuestionType() {
		    $('#question-type').on('change', (event) => {

		      window.location.href = "{{ route('admin.question.create') . '?type=:type' }}".replace(':type', event.target.value)
		    })
		  }

		  function renderOldValue() {
		    const questionType = @json(old('type', QUESTION_MULTI_CHOICE));

		    if (questionType == @json(QUESTION_TRUE_FALSE)) {
		      const oldAnswers = @json(old('answers'));
		      const oldErrorAnswers = @json($errors->get('answers.*'));
		      const oldCorrectAnswers = @json(old('correct_answer'));

		      oldAnswers && oldAnswers.forEach(function(content, index) {
		        if (index != 0) {
		          if (oldErrorAnswers['answers.' + index]) {
		            addContent(content, oldErrorAnswers['answers.' + index][0], oldCorrectAnswers[index]);
		          } else {
		            addContent(content, null, oldCorrectAnswers[index]);
		          }
		        }
		      });
		    }
		  }

			function readURL(input) {
				if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function(e) {
								$('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').attr('src', e.target.result);
								$('#imagePreview').hide();
								$('#imagePreview').fadeIn(650);
						}
						reader.readAsDataURL(input.files[0]);
				}
			}

			$("#imageUpload").change(function() {
				readURL(this);
			});
		</script>
@endsection
