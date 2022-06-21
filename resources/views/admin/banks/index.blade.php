@extends('layouts.admin')

@section('title', 'Quản lý câu hỏi')

@section('content')
  {{-- Modal show subject --}}
  <div class="modal" id="show-question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Thông tin câu hỏi</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            <div id='question-table'>
            </div>
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
          <a href="{{ route('admin.question-bank.wait-accept') }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-check-square"></i> Câu hỏi chờ duyệt (10)
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter js-dataTable-full" id="exam-table">
            <thead>
              <tr style="">
                <th style="width: 6%;" class="text-center">STT</th>
                <th style="width: 35%;" class="text-center">Câu hỏi</th>
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
                      <button class="btn btn-sm btn-alt-secondary show-btn" data-bs-toggle="tooltip" title="Xem thông tin" data-id="{{ $question->id }}">
                        <i class="fa fa-fw fa-eye"></i>
                      </button>
                      <form method="POST" action="{{ route('admin.question-bank.destroy', ['question_bank' => $question->id]) }}" id="delete_form_{{ $question->id }}">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $question->id }}" data-name="{{ $loop->iteration }}"
                          data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
                          <i class="fa fa-fw fa-trash"></i>
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
  </div>
@endsection


@section('js_after')
  <script>
    const questions = @json($questions);

    $('.show-btn').on('click', function(e) {
      const questionId = $(this).data('id');
      const question = questions.find(question => question.id == questionId);
      fetch('{{ route('admin.question-bank.template', ['question_bank' => ':id']) }}'.replace(':id', questionId))
        .then(res => res.json())
        .then(data => {
          $('#question-table').html(data.html);
          $('#show-question').modal('show');
        });
    });

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
