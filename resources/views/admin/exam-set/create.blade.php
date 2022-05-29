@extends('layouts.admin')

@section('title', 'Giáo viên')

@section('content')
  <div class="content content-boxed">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Tạo đề thi</h3>
        <div class="block-options">
          <a href="{{ route('admin.exam-set.index') }}" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn btn-sm btn-success" onclick="createExamSet()">
            <i class="fa fa-random"></i> Tạo đề thi
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-lg-12 space-y-5">
            <!-- Form Horizontal - Default Style -->
            <form id="create_exam_set" class="" action="{{ route('admin.exam-set.store') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-12">
                  <div class="row mb-2">
                    <label class="col-sm-12 col-form-label">Tên đề thi</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nhập tên đề thi">
                      @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label">Loại đề thi</label>
                    <div class="col-sm-12">
                      <select id="subject" class="form-select @error('type') is-invalid @enderror" name="type">
                        @foreach (config('fixeddata.exam_set_type') as $type => $label)
                          <option value="{{ $type }}" @selected(old('type') == $type)>{{ $label }}</option>
                        @endforeach
                      </select>
                      @error('type')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label">Số lượng câu hỏi</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control @error('total_question') is-invalid @enderror" name="total_question" value="{{ old('total_question') }}"
                        placeholder="Nhập số lượng câu hỏi">
                      @error('total_question')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label">Thời gian làm bài</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control @error('execute_time') is-invalid @enderror" name="execute_time" value="{{ old('execute_time') }}"
                        placeholder="Nhập thời gian làm bài">
                      @error('execute_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label">Môn học</label>
                    <div class="col-sm-12">
                      <select id="subject" class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                        @foreach ($subjects as $subject)
                          <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                      </select>
                      @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-9">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label">Các nội dung (chọn nhiều)</label>
                    <div class="col-sm-12">
                      <select id="subject-content" class="js-select2 form-select @error('subject_content_ids') is-invalid @enderror" name="subject_content_ids[]" multiple>
                        @foreach ($subjects[0]->contents as $subjectContent)
                          <option value="{{ $subjectContent->id }}">{{ $subjectContent->name }}</option>
                        @endforeach
                      </select>
                      @error('subject_content_ids')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css_before')
  <link rel="stylesheet" href="{{ asset('/js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('/js/plugins/select2/js/select2.full.min.js') }}"></script>

  <script>
    One.helpersOnLoad(['jq-select2']);
    
    $(".js-select2").select2({
      language: {
        noResults: function() {
          return "Không có dữ liệu";
        }
      }
    });

    function createExamSet() {
      $('#create_exam_set').submit();
    }
  </script>
@endsection
