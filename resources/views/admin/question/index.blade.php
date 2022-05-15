
@extends('layouts.admin')

@section('title', 'Quản lý câu hỏi')

@section('content')
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách câu hỏi</h3>
        <div class="block-options">
          <a href="{{ route('admin.question.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter" id="exam-table">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 10%;" class="text-center">Câu hỏi</th>
              <th style="width: 10%;" class="text-center">Môn học</th>
              <th style="width: 25%;" class="text-center">Trạng thái</th>
              <th style="width: 10%;" class="text-center">Thời gian tạo</th>
              <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($questions as $question)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-truncate">{!! $question->content !!}</td>
                <td class="text-center">{{ $question->subject->name }}</td>
                <td class="text-center">{{ config('fixeddata.question_status')[$question->status] }}</td>
                <td class="text-center">{{ $question->created_at }}</td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="{{ route('admin.question.edit', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Chỉnh sửa') }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.question.destroy', ['question' => $question->id]) }}" id="delete_form_{{ $question->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $question->id }}"
                        data-name="{{ $loop->iteration }}" data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </form>
                  </div>
                </td>
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
    number = $(this).data("name");
    toast.fire({
      title: '{{ __('Xác nhận') }}',
      text: 'Bạn có chắc chắn muốn xóa câu hỏi số ' + number + '?',
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