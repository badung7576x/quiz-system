@extends('layouts.admin')

@section('title', 'Giáo viên')

@section('content')
  <form id="create_question" class="space-y-4" action="{{ route('admin.question.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content content-boxed">
      <div class="block block-rounded">
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
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                  </select>
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
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row mb-3">
                <label class="col-sm-12 col-form-label">Mức độ câu hỏi</label>
                <div class="col-sm-12">
                  <select class="form-select @error('level') is-invalid @enderror" name="level">
                    @foreach (config('fixeddata.question_level') as $level => $label)
                      <option value="{{ $level }}">{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row mb-3">
                <label class="col-sm-12 col-form-label">Loại câu hỏi</label>
                <div class="col-sm-12">
                  <select id="question-type" class="form-select @error('type') is-invalid @enderror" name="type">
                    @foreach (config('fixeddata.question_type') as $type => $label)
                      <option value="{{ $type }}">{{ $label }}</option>
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
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Trình soạn thảo</h3>
          <div class="block-options">

          </div>
        </div>
        <div class="block-content block-content-full">
          <div class="row" id="question-form">

          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('css_before')

@endsection

@section('js_after')
  @include('admin.question._configCkeditor4')
  <script>
    const subjects = {!! json_encode($subjects) !!};
    $(document).ready(function() {
      showOldFormValue();
      handleSelectSubject();
      clearValidateError();
      renderQuestionForm();
    });

    function renderQuestionForm() {
      getAndShowForm()
      $('#question-type').on('change', function() {
        const type = $(this).val();
        getAndShowForm(type);
      })
    }

    async function getAndShowForm(type) {
      response = await fetch("{{ route('admin.question.form') }}" + "?type=" + type, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      });
      const data = await response.json();
      $('#question-form').html(data.html);
      initCkeditor();
    }

    function initCkeditor() {
      $(".ckeditor").each(function(_, ckeditor) {
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

    function changeQuestionSetOptions(options, selected = []) {
      $('#subject-content').empty();
      if (options.length) {
        options.forEach(option => {
          $('#subject-content').append(`<option value="${option.id}" ${selected?.includes(option.id.toString()) ? 'selected' : ''}>${option.name}</option>`);
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
      const oldSubjectId = {!! json_encode(old('subject_id')) !!};
      const oldSubjectContentId = {!! json_encode(old('subject_content_id')) !!};
      let subjectContents = oldSubjectId ? subjects.find(item => item.id == oldSubjectId).contents : subjects[0].contents;
      changeQuestionSetOptions(subjectContents, oldSubjectContentId);
    }
  </script>
@endsection
