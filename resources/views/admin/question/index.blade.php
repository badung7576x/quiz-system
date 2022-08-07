@extends('layouts.admin')

@section('title', 'Quản lý câu hỏi')

@section('content')
  <div class="modal" id="modal-import-question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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
                    <h6 class="text-danger mb-2">※  Lưu ý về file câu hỏi</h6>
                    <ul>
                      <li>File import phải có định dạng Excel</li>
                      <li>
                        File câu hỏi phải có đủ các thông tin như dưới đây
                        <ul>
                          <li>Câu hỏi nhiều lựa chọn</li>
                          <table class="table table-bordered">
                            <tr>
                              <th class="text-center" style="width: 15px">STT</th>
                              <th class="text-center" style="width: 50px">Loại câu hỏi</th>
                              <th class="text-center" style="width: 200px">Câu hỏi</th>
                              <th class="text-center" style="width: 80px">Đáp án 1</th>
                              <th class="text-center" style="width: 80px">Đáp án 2</th>
                              <th class="text-center" style="width: 80px">Đáp án 3</th>
                              <th class="text-center" style="width: 80px">Đáp án 4</th>
                              <th class="text-center" style="width: 30px">Đáp án đúng</th>
                              <th class="text-center" style="width: 30px">Độ khó</th>
                            </tr>
                            <tr>
                              <td class="text-center">1</td>
                              <td class="text-center">MULTI_CHOICE</td>
                              <td class="text-truncate">Nội dung câu hỏi</td>
                              <td class="text-truncate">Đáp án 1</td>
                              <td class="text-truncate">Đáp án 2</td>
                              <td class="text-truncate">Đáp án 3</td>
                              <td class="text-truncate">Đáp án 4</td>
                              <td class="text-center">2</td>
                              <td class="text-center">2</td>
                            </tr>
                          </table>

                          <li>Câu hỏi đúng/sai</li>
                          <table class="table table-bordered">
                            <tr>
                              <th class="text-center" style="width: 15px">STT</th>
                              <th class="text-center" style="width: 50px">Loại câu hỏi</th>
                              <th class="text-center" style="width: 200px">Nội dung chính</th>
                              <th class="text-center" style="width: 200px">Câu hỏi</th>
                              <th class="text-center" style="width: 100px">Đáp án</th>
                              <th class="text-center" style="width: 100px">Độ khó</th>
                            </tr>
                            <tr>
                              <td class="text-center" style="width: 25px">1</td>
                              <td class="text-center" style="width: 50px" rowspan="2">TRUE_FALSE</td>
                              <td class="text-truncate" style="max-width: 200px" rowspan="2">Nội dung câu hỏi</td>
                              <td class="text-truncate" style="max-width: 240px">Câu hỏi 1</td>
                              <td class="text-center" style="max-width: 120px">1</td>
                              <td class="text-center" style="max-width: 120px" rowspan="2">1</td>
                            </tr>
                            <tr>
                              <td class="text-center" style="width: 25px">2</td>
                              <td class="text-truncate" style="max-width: 240px">Câu hỏi 2</td>
                              <td class="text-center" style="max-width: 120px">0</td>
                            </tr>
                          </table>
                        </ul>
                      </li>
                      <li>Loại câu hỏi: ['MULTI_CHOICE', 'TRUE_FALSE']</li>
                      <li>Độ khó: ['1: Dễ', '2: Trung bình', '3: Khó']</li>
                      <li>Mỗi loại câu hỏi ở một file riêng biệt, không gộp nhiều loại câu hỏi với nhau.</li>
                    </ul>
                  </div>
                  <hr>
                  <div class="col-sm-12">
                    <input id="import_file" class="form-control @error('question_file') is-invalid @enderror" type="file"
                      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="question_file"
                      data-buttonText="Chọn file">
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
          <a href="{{ route('admin.question.create') . '?type=' . QUESTION_MULTI_CHOICE }}" class="btn btn-outline-primary btn-sm">
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
                <th style="width: 40%" class="text-truncate">Câu hỏi</th>
                <th style="width: 15%;" class="text-center">Loại câu hỏi</th>
                <th style="width: 15%;" class="text-center">Trạng thái</th>
                <th style="width: 15%;" class="text-center">Thời gian tạo</th>
                <th style="width: 14%;" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
                  <td class="text-center">{!! config('fixeddata.question_type')[$question->type] !!}</td>
                  <td class="text-center">{!! render_status($question->status) !!}</td>
                  <td class="text-center">{{ $question->created_at }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{ route('admin.question.show', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Xem') }}">
                        <i class="fa fa-fw fa-eye"></i>
                      </a>
                      @if ($question->created_by == auth()->user()->id)
                        @if($question->status < QUESTION_STATUS_REVIEWED)
                          <a href="{{ route('admin.question.edit', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Chỉnh sửa') }}">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                          </a>
                        @endif
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
