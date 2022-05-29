
@extends('layouts.admin')

@section('title', 'Quản lý giáo viên')

@section('content')
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách giáo viên</h3>
        <div class="block-options">
          <a href="{{ route('admin.teacher.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter js-dataTable-full" id="exam-table">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 10%;" class="text-center">Mã GV</th>
              <th style="width: 25%;" class="text-center">Họ và tên</th>
              <th style="width: 15%;" class="text-center">Môn học</th>
              <th style="width: 15%;" class="text-center">Email</th>
              <th style="width: 10%;" class="text-center">Giới tính</th>
              <th style="width: 10%;" class="text-center">Ngày sinh</th>
              <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($teachers as $teacher)
              <tr>
                <th class="text-center">{{ $loop->iteration }}</th>
                <th class="text-center fw-normal">{{ $teacher->code }}</th>
                <th class="text-center fw-normal">{{ $teacher->fullname }}</th>
                <th class="text-center fw-normal">{{ $teacher->subject->name }}</th>
                <th class="text-center fw-normal">{{ $teacher->email }}</th>
                <th class="text-center fw-normal">{{ GENDER[$teacher->gender] }}</th>
                <th class="text-center fw-normal">{{ $teacher->date_of_birth }}</th>
                <th class="text-center fw-normal">
                  <div class="btn-group">
                    <a href="{{ route('admin.teacher.edit', ['teacher' => $teacher->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Chỉnh sửa') }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.teacher.destroy', ['teacher' => $teacher->id]) }}" id="delete_form_{{ $teacher->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $teacher->id }}"
                        data-name="{{ $teacher->fullname }}" data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
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
  $('.delete-btn').on('click', function(e) {
    e.preventDefault();
    id = $(this).data("id");
    teacher = $(this).data("name");
    toast.fire({
      title: '{{ __('Xác nhận') }}',
      text: 'Bạn có chắc chắn muốn xóa giáo viên "' + teacher + '"?',
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