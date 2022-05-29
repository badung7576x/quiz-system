@extends('layouts.admin')

@section('title', 'Phân công nhiệm vụ')

@section('content')
  <div class="modal" id="assign-teacher" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Phân công giáo viên</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <form id="assign-form" action="{{ route('admin.assignment.assign') }}" method="POST">
            <div class="block-content fs-sm">
              @csrf
              <div class="row mb-3">
                <label class="col-12 col-form-label">Giáo viên</label>
                <div class="col-12">
                  <input type="hidden" id="questionId" name="questions[]">
                  <select class="form-select @error('teacher_id') is-invalid @enderror" name="teacher_id">
                    @foreach ($teachers as $teacher)
                      <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>{{ $teacher->fullname }}</option>
                    @endforeach
                  </select>
                  @error('teacher_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="block-content block-content-full text-end bg-body">
              <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-user-cog me-1"></i>Gán</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách câu hỏi</h3>
        <div class="block-options">
          <button class="btn btn-sm btn-success" onclick="showAssignModal()">
            <i class="fa fa-user-cog"></i> Phân công
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter" id="exam-table">
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
                      <a href="{{ route('admin.question.show', ['question' => $question->id]) }}" class="btn btn-sm btn-alt-secondary" title="{{ __('Xem') }}">
                        <i class="fa fa-fw fa-eye"></i>
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
