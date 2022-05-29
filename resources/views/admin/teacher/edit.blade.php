@extends('layouts.admin')

@section('title', 'Giáo viên')

@section('content')
  <div class="content content-boxed">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Thông tin giáo viên</h3>
        <div class="block-options">
          <a href="javascript:history.back()" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn btn-sm btn-success" id="save_btn">
            <i class="fa fa-save"></i> Cập nhật
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
            <form id="update_teacher" class="space-y-4" action="{{ route('admin.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="id" value="{{ $teacher->id }}">
              <div class="row">
                <div class="col-9">
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Mã giáo viên') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $teacher->code) }}" disabled
                        placeholder="{{ __('Nhập mã giáo viên') }}">
                      @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $teacher->email) }}"
                        placeholder="{{ __('Nhập địa chỉ email') }}" disabled>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Họ và tên') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $teacher->fullname) }}"
                        placeholder="{{ __('Nhập họ và tên') }}">
                      @error('fullname')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Số điện thoại') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $teacher->phone_number) }}"
                        placeholder="{{ __('Nhập số điện thoại') }}">
                      @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('CMND/CCCD') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('identity_number') is-invalid @enderror" name="identity_number" value="{{ old('identity_number', $teacher->identity_number) }}"
                        placeholder="{{ __('Nhập CMND/CCCD') }}">
                      @error('identity_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="gender">{{ __('Giới tính') }}</label>
                    <div class="col-sm-3">
                      <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                        <option value="1" @selected(old('gender', $teacher->gender) == 1)>Nam</option>
                        <option value="0" @selected(old('gender', $teacher->gender) == 0)>Nữ</option>
                      </select>
                      @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- <label class="col-sm-2 col-form-label" for="date_of_birth">{{ __('Ngày sinh') }}</label> --}}
                    <div class="col-sm-6">
                      <input type="text" class="js-flatpickr form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth) }}"
                        data-date-format="d-m-Y" placeholder="Chọn ngày sinh">
                      @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Địa chỉ') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $teacher->address) }}"
                        placeholder="{{ __('Nhập địa chỉ') }}">
                      @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Môn học giảng dạy</label>
                    <div class="col-sm-9">
                      <select class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                        @foreach($subjects as $subject)
                          <option value="{{ $subject->id }}" @selected(old('subject_id', $teacher->subject_id) == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                      </select>
                      @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Vai trò') }}</label>
                    <div class="col-sm-9">
                      <select class="form-select @error('role') is-invalid @enderror" name="role">
                        @foreach($roles as $value => $role)
                          <option value="{{ $value }}" @selected(old('role', $teacher->role) == $value)>{{ $role }}</option>
                        @endforeach
                      </select>
                      @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Mật khẩu') }}</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        placeholder="{{ __('Nhập mật khẩu') }}">
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('Mật khẩu (xác nhận)') }}</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm"
                        placeholder="{{ __('Nhập mật khẩu') }}">
                      @error('password_confirm')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="avatar-upload">
                    <div class="avatar-edit">
                      <input type='file' name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg" />
                      <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                      <div id="imagePreview"
                        style="background-image: url({{ $teacher->avatar ?? '/images/default_avatar.png' }});">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center">
                    <label class="col-form-label">Hình ảnh đại diện</label>
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
  <link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
  <script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script>
    One.helpersOnLoad(['js-flatpickr']);

    $('#save_btn').on("click", function() {
      $('#update_teacher ').submit();
    });

    const readURL = (input) => {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
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
