
@extends('layouts.admin')

@section('title', __('Quản lý lớp và học sinh'))

@section('content')
  <div class="modal" id="modal-input-file" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Nhập danh sách học sinh từ excel</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            @error('modal')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
            <form id="import_examinee_form" action="{{ route('admin.student.import', ['class' => $class->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="col-12 mb-4">
                <div class="row">
                  <div class="col-sm-12">
                    <input id="import_file" class="form-control @error('import_file') is-invalid @enderror" type="file"
                      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="import_file">
                    @error('import_file')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="block-content block-content-full text-end bg-body">
            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">{{ __('Hủy') }}</button>
            <button type="button" class="btn btn-sm btn-primary" id="id_import_btn">{{ __('Nhập dữ liệu') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách học sinh lớp: <a href="{{ route('admin.class.index', $class->id) }}">{{ $class->name }}</a></h3>
        <div class="block-options">
          <a href="{{ route('admin.student.create', ['class' => $class->id]) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
        @if ($class->students->count() == 0)
          @if (1)
            <div class="block-options">
              <button type="button" id="remove_sbd_btn" class="btn btn-sm btn-outline-warning">
                <i class="fa fa-times-circle"></i> Gỡ SBD
              </button>
            </div>
          @else
            <div class="block-options">
              <button type="button" id="gen_sbd_btn" class="btn btn-sm btn-outline-info">
                <i class="fa fa-address-card"></i> Gán SBD
              </button>
            </div>
          @endif
        @endif
        <div class="block-options">
          <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal-input-file">
            <i class="fa fa-file-import"></i> Nhập từ file Excel
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter" id="exam-table">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 15%;" class="text-center">Mã số</th>
              <th style="width: 25%;" class="text-center">Họ và tên</th>
              <th style="width: 20%;" class="text-center">Giới tính</th>
              <th style="width: 20%;" class="text-center">Ngày sinh</th>
              <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($class->students as $student)
              <tr>
                <th class="text-center">{{ $loop->iteration }}</th>
                <th class="text-center fw-normal">{{ $student->student_code }}</th>
                <th class="text-center fw-normal">{{ $student->full_name }}</th>
                <th class="text-center fw-normal">{{ GENDER[$student->gender] }}</th>
                <th class="text-center fw-normal">{{ $student->date_of_birth }}</th>
                <th class="text-center fw-normal">
                  <div class="btn-group">
                    <a href="{{ route('admin.student.edit', ['class' => $class->id, 'student' => $student->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Chỉnh sửa') }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.student.destroy', ['class' => $class->id, 'student' => $student->id]) }}" id="delete_form_{{ $student->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $student->id }}"
                        data-name="{{ $student->full_name }}" data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </form>
                  </div>
                </th>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection


@section('js_after')
<script>
  $(document).ready(function() {
    $('#id_import_btn').on('click', function(e) {
      $('#import_examinee_form').submit();
      $(this).html('<i class="fa fa-cog fa-spin"></i> {{ __('Đang nhập...') }}');
    });
  })

  $('.delete-btn').on('click', function(e) {
    e.preventDefault();
    id = $(this).data("id");
    studentName = $(this).data("name");
    toast.fire({
      title: '{{ __('Xác nhận') }}',
      text: 'Bạn có chắc chắn muốn xóa học sinh "' + studentName + '"?',
      icon: 'warning',
      showCancelButton: true,
      customClass: {
        confirmButton: 'btn btn-danger m-1',
        cancelButton: 'btn btn-secondary m-1'
      },
      confirmButtonText: '{{ __('Xác nhận') }}',
      cancelButtonText: '{{ __('Hủy') }}',
      html: false,
      preConfirm: e => {
        return new Promise(resolve => {
          setTimeout(() => {
            resolve();
          }, 50);
        });
      }
    }).then(result => {
      if (result.value) {
        $('#delete_form_' + id).submit();
      }
    });
  });

</script>

@endsection