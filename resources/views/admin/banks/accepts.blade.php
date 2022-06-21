@extends('layouts.admin')

@section('title', 'Duyệt câu hỏi vào ngân hàng')

@section('content')
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách câu hỏi</h3>
        <div class="block-options">
          
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter js-dataTable-full" id="exam-table">
            <thead>
              <tr style="">
                <th style="width: 4%;" class="text-center"></th>
                <th style="width: 10%;" class="text-center">STT</th>
                <th style="width: 50%" class="text-truncate">Câu hỏi</th>
                <th style="width: 12%;" class="text-center">Tạo bởi</th>
                <th style="width: 12%;" class="text-center">Thời gian tạo</th>
                <th style="width: 12%;" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center">
                    <input type="checkbox" class="form-check-input" name="question_id" value="{{ $question->id }}">
                  </td>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
                  <td class="text-center">{{ $question->teacher->fullname }}</td>
                  <td class="text-center">{{ $question->created_at }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button class="btn btn-sm btn-alt-secondary" title="{{ __('Xem') }}">
                        <i class="fa fa-fw fa-eye"></i>
                      </button>
                      <a href="{{ route('admin.question.show', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-success" title="{{ __('Duyệt') }}">
                        <i class="fa fa-fw fa-check-circle"></i>
                      </a>
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
    function showAssignModal() {
      const questionIds = [];
      $('input[name="question_id"]:checked').each(function() {
        questionIds.push($(this).val());
      });
      if(questionIds.length == 0) {
        showNotify('danger', 'Bạn chưa lựa chọn câu hỏi nào');
        return;
      } else {
        $('#questionId').val(questionIds);
        $('#assign-teacher').modal('show');
      }
    }
  </script>
@endsection
