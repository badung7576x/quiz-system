@extends('layouts.admin')

@section('title', 'Soạn thảo câu hỏi')

@section('content')
  <form class="space-y-4" action="{{ route('admin.question.update', ['question' => $question->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="content content-boxed">
      <div class="block block-rounded">
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
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}" @selected(old('subject_id', $question->subject_id) == $subject->id)>{{ $subject->name }}</option>
                    @endforeach
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
                    @foreach ($subjects[0]->contents as $subjectContent)
                      <option value="{{ $subjectContent->id }}">{{ $subjectContent->name }}</option>
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
                  <select id="question-type" class="form-select" name="type">
                    @foreach (config('fixeddata.question_type') as $type => $label)
                      <option value="{{ $type }}" @selected(old('level', $question->type) == $type)>{{ $label }}</option>
                    @endforeach
                  </select>
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
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Trình soạn thảo</h3>
          <div class="block-options">

          </div>
        </div>
        <div class="block-content block-content-full">
          <div class="row" id="question-form">
            @include('admin.question._multichoice-edit')
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('css_before')

@endsection

@section('js_after')
  <script src="https://cdn.ckeditor.com/4.18.0/standard-all/ckeditor.js"></script>
  <script>
    const subjects = {!! json_encode($subjects) !!};
    $(document).ready(function() {
      showOldFormValue();
      handleSelectSubject();
      clearValidateError();
      initCkeditor();
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

    function handleSelectSubject() {
      $('#subject').on('change', function() {
        const subjectId = $(this).val();
        const subject = subjectId ? subjects.find(item => item.id == subjectId) : null;
        const subjectContents = subject?.contents || subjects[0].contents;
        changeQuestionSetOptions(subjectContents);
      })
    }

    function changeQuestionSetOptions(options, selected) {
      $('#subject-content').empty();
      if (options.length) {
        options.forEach(option => {
          $('#subject-content').append(`<option value="${option.id}" ${selected == option.id.toString() ? 'selected' : ''}>${option.name}</option>`);
        })
      } else {
        $('#subject-content').append(`<option value="">Môn học chưa có nội dung</option>`);
      }
    }

    function clearValidateError() {
      $("input, select").click(function() {
        $(this).removeClass('is-invalid')
      });
    }

    function showOldFormValue() {
      let oldSubjectId = {!! json_encode(old('subject_id')) !!};
      if (!oldSubjectId) oldSubjectId = {!! json_encode($question->subject_id) !!};
      let oldSubjectContentId = {!! json_encode(old('subject_content_id')) !!};
      if (!oldSubjectContentId) oldSubjectContentId = {!! json_encode($question->subject_content_id) !!};
      let subjectContents = oldSubjectId ? subjects.find(item => item.id == oldSubjectId).contents : subjects[0].contents;
      changeQuestionSetOptions(subjectContents, oldSubjectContentId);
    }
  </script>
@endsection