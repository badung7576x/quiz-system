@extends('layouts.admin')

@section('title', 'Quản lý câu hỏi')

@section('content')
  <div class="modal" id="modal-import-question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Nhập câu hỏi từ file</h3>
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
            <form id="import_question_form" action="{{ route('admin.question.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="col-12 mb-4">
                <div class="row">
                  <div class="col-sm-12">
                    <input id="import_file" class="form-control @error('question_file') is-invalid @enderror" type="file"
                      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="question_file">
                    @error('question_file')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="block-content block-content-full text-end bg-body">
            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-sm btn-outline-primary" id="id_import_btn">Nhập dữ liệu</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách câu hỏi</h3>
        <div class="block-options">
          <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-import-question">
            <i class="fa fa-file-import"></i> Nhập từ file
          </button>
          <a href="{{ route('admin.question.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter js-dataTable-full" id="exam-table">
            <thead>
              <tr style="">
                <th style="width: 6%;" class="text-center">STT</th>
                <th style="width: 25%" class="text-truncate">Câu hỏi</th>
                <th style="width: 10%;" class="text-center">Trạng thái</th>
                <th style="width: 10%;" class="text-center">Thời gian tạo</th>
                <th style="width: 14%;" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
                  <td class="text-center">{!! render_status($question->status) !!}</td>
                  <td class="text-center">{{ $question->created_at }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{ route('admin.question.show', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Xem') }}">
                        <i class="fa fa-fw fa-eye"></i>
                      </a>
                      @if ($question->created_by == auth()->user()->id)
                        <a href="{{ route('admin.question.edit', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Chỉnh sửa') }}">
                          <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.question.destroy', ['question' => $question->id]) }}" id="delete_form_{{ $question->id }}">
                          @csrf
                          @method('delete')
                          <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $question->id }}" data-name="{{ $loop->iteration }}"
                            data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
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

    $('#id_import_btn').on('click', function(e) {
      if($('#import_file').val() == '') return;
      $('#import_question_form').submit();
      $(this).html('<i class="fa fa-cog fa-spin"></i> {{ __('Đang nhập...') }}');
    });

    @if ($errors->has('modal'))
      $('#modal-import-question').modal('show');
    @endif
  </script>

@endsection
