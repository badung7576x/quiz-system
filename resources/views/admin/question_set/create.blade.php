@extends('layouts.admin')

@section('title', __('Bộ câu hỏi'))

@section('content')
  <!-- Page Content -->
  <div class="content">
    <!-- Dynamic Table Full -->
    <div class="block block-rounded">

      <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('Thêm bộ câu hỏi') }}</h3>
        <div class="block-options">
          <a href="{{ route('admin.question-set.index') }}" class="btn btn-sm btn-dark">
            <i class="fa fa-arrow-left"></i> {{ __('Quay lại') }}
          </a>
          <button type="submit" class="btn btn-sm btn-success" id="submit-btn">
            <i class="fa fa-save"></i> {{ __('Tạo mới') }}
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          @error('general')
            <div class="col-12">
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            </div>
          @enderror
        </div>
        <form id="question-set-form" action="{{ route('admin.question-set.store') }}" method="post" enctype="multipart/form-data">
          <div class="row">
            @csrf
            <div class="col-8 mb-4">
              <label class="form-label">{{ __('Tên bộ câu hỏi') }}</label>
              <input type="text" class="form-control @error('set_name') is-invalid @enderror" name="set_name" value="{{ old('set_name') }}">
              @error('set_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mb-4">
              <label class="form-label">{{ __('Môn học') }}</label>
              <select id="exam-type" class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                <option value="" selected="">Chọn môn học</option>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                    {{ $subject->name }}
                  </option>
                @endforeach
              </select>
              @error('subject_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 mb-4">
              <label class="form-label">{{ __('File danh sách câu hỏi') }}</label>
              <input id="import_file" class="form-control @error('import_file') is-invalid @enderror" type="file"
                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="import_file">
              @error('import_file')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- END Dynamic Table Full -->
  </div>
  <!-- END Page Content -->
@endsection

@section('js_after')
  <script>
    $(document).ready(function() {
      clearValidateError();
      submitForm();
    });

    function submitForm() {
      $('#submit-btn').on("click", function() {
        $('#question-set-form').submit();
      });
    }

    function clearValidateError() {
      $("input, select").click(function() {
        $(this).removeClass('is-invalid')
      });
    }
  </script>
@endsection
