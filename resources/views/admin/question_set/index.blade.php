@extends('layouts.admin')

@section('title', __('Bộ câu hỏi'))

@section('content')

  <div class="modal" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Chỉnh sửa bộ câu hỏi</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <form id="edit_form" action="#" method="POST">
            <div class="block-content fs-sm">
              @method('put')
              @csrf
              @error('update')
                <div class="alert alert-danger" id="edit_error">
                  {{ $message }}
                </div>
              @enderror
              <input type="hidden" name="id" value="{{ old('id') }}">
              <div class="row mb-3">
                <label class="col-12 col-form-label" for="set_name">Tên bộ câu hỏi</label>
                <div class="col-12">
                  <input type="text" class="form-control @error('set_name') is-invalid @enderror" name="set_name" value="{{ old('set_name') }}">
                  @error('set_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-12 col-form-label" for="subject_prefix">Môn thi</label>
                <div class="col-12">
                  <select class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                    <option value="" selected="">Chọn môn thi</option>
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                        {{ $subject->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('subject_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="block-content block-content-full text-end bg-body">
              <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
              <button type="button" class="btn btn-sm btn-success" id='save_btn'><i class="fa fa-save me-1"></i>Lưu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách bộ câu hỏi</h3>
        <div class="block-options">
          <a type="button" class="btn btn-primary btn-sm" href="{{ route('admin.question-set.create') }}">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="exam-table">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 40%;" class="text-center">Tên bộ câu hỏi</th>
              <th style="width: 15%;" class="text-center">Môn học</th>
              <th style="width: 15%;" class="text-center">Số lượng câu hỏi</th>
              <th style="width: 14%;" class="text-center">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($questionSets as $questionSet)
              <tr>
                <th class="text-center">{{ $loop->iteration }}</th>
                <th class="text-center fw-normal">
                  <a href="{{ $questionSet->questions_count > 0 ? route('admin.question-set.show', ['question_set' => $questionSet->id]) : '#' }}">
                    {{ $questionSet->set_name }}
                  </a>
                </th>
                <th class="text-center fw-normal">{{ $questionSet->subject->name }}</th>
                <th class="text-center fw-normal">{{ $questionSet->questions_count }}</th>
                <th class="text-center fw-normal">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary edit-btn" data-bs-toggle="tooltip" title="Chỉnh sửa" data-id="{{ $questionSet->id }}"
                      data-set_name="{{ $questionSet->set_name }}" data-subject_id="{{ $questionSet->subject->id }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.question-set.destroy', $questionSet->id) }}" id="delete_form_{{ $questionSet->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $questionSet->id }}"
                        data-name="{{ $questionSet->set_name }}" data-bs-toggle="tooltip" title="Xóa">
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
      @if ($errors->has('update_modal'))
        setEditFormAction();
        $('#edit_modal').modal('show');
      @endif

      $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        id = $(this).data("id");
        setName = $(this).data("name");
        toast.fire({
          title: 'Xác nhận',
          text: 'Bạn có chắc chắn xóa bộ câu hỏi "' + setName + '"?',
          icon: 'warning',
          showCancelButton: true,
          customClass: {
            confirmButton: 'btn btn-danger m-1',
            cancelButton: 'btn btn-secondary m-1'
          },
          confirmButtonText: 'Xác nhận',
          cancelButtonText: 'Hủy',
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

      $('.edit-btn').on('click', function(e) {
        const btn = $(this);
        $('#edit_error').remove();
        $('#edit_form input:gt(2)').each(function(idx) {
          $(this).removeClass('is-invalid');
          attr = $(this).attr('name');
          $(this).val(btn.data(attr));
        });
        $('#edit_form select').val(btn.data('subject_id'));

        setEditFormAction();
        $('#edit_modal').modal('show');
      });

      $('#save_btn').on('click', function(e) {
        e.preventDefault();
        $('#edit_form input:gt(2)').each(function(idx) {
          $(this).prop('disabled', false);
        });
        $('#edit_form select').prop('disabled', false);
        $('#edit_form').submit();
      })

      function setEditFormAction() {
        id = $("#edit_modal input[name='id']").val();
        url = "{{ route('admin.question-set.update', ':id') }}";
        url = url.replace(':id', id);
        $('#edit_form').attr('action', url);
      }

    });
  </script>
@endsection
