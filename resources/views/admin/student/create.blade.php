@extends('layouts.admin')

@section('title', 'Quản lý lớp và học sinh')

@section('content')
  <div class="content content-boxed">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Thông tin học sinh</h3>
        <div class="block-options">
          <a href="javascript:history.back()" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn btn-sm btn-success" id="save_btn">
            <i class="fa fa-save"></i> Tạo mới
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-lg-12 space-y-5">
            @error('error')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
            <!-- Form Horizontal - Default Style -->
            <form id="create_student" class="space-y-4" action="{{ route('admin.student.store', ['class' => $class->id]) }}" method="POST">
              @csrf
              <div class="row">
                <label class="col-sm-3 col-form-label" for="last_name">{{ __('Họ và tên') }}</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"
                    placeholder="{{ __('Họ và tên đệm') }}">
                  @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-3">
                  <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"
                    placeholder="{{ __('Tên') }}">
                  @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="date_of_birth">{{ __('Ngày sinh') }}</label>
                <div class="col-sm-6">
                  <input type="text" class="js-flatpickr form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth"
                    value="{{ old('date_of_birth') }}" data-date-format="d-m-Y">
                  @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="gender">{{ __('Giới tính') }}</label>
                <div class="col-sm-6">
                  <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                      <option value="MALE" @selected(old('gender') == 'MALE')>Nam</option>
                      <option value="FEMALE" @selected(old('gender') == 'MALE')>Nữ</option>
                  </select>
                  @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
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
  <link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
  <script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script>
    One.helpersOnLoad(['js-flatpickr']);

    $('#save_btn').on("click", function() {
      $('#create_student').submit();
    });
  </script>
@endsection
