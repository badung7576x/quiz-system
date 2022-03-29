@extends('layouts.admin')

@section('title', __('Quản lý lớp và học sinh'))

@section('content')
  {{-- Modal create class --}}
  <div class="modal" id="create-class" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Thêm lớp học</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <form id="create-form" action="{{ route('admin.class.store') }}" method="POST">
            <div class="block-content fs-sm">
              @csrf
              <div class="row mb-2">
                <label class="col-12 col-form-label">Tên lớp học <span style="color: red">*</span></label>
                <div class="col-12">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', '') }}">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-12 col-form-label">Mô tả</label>
                <div class="col-12">
                  <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ old('description', '') }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="block-content block-content-full text-end bg-body">
              <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save me-1"></i>Tạo</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit class --}}
  <div class="modal" id="edit-class" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Chỉnh sửa thông tin</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <form id="edit-form" action="#" method="POST">
            <div class="block-content fs-sm">
              @csrf
              @method('PUT')
              <input type="hidden" name="id" id="class-id" value="">
              <div class="row mb-2">
                <label class="col-12 col-form-label">Tên lớp học <span style="color: red">*</span></label>
                <div class="col-12">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', '') }}">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-12 col-form-label">Mô tả</label>
                <div class="col-12">
                  <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" id="description">{{ old('description', '') }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="block-content block-content-full text-end bg-body">
              <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save me-1"></i>Cập nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách lớp học</h3>
        <div class="block-options">
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#create-class">
            <i class="fa fa-plus"></i>Thêm mới
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter" id="exam-table">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 20%;" class="text-center">Tên lớp</th>
              <th style="width: 40%;" class="text-center">Mô tả</th>
              <th style="width: 20%;" class="text-center">Số học sinh</th>
              <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($classes as $class)
              <tr>
                <th class="text-center">{{ $loop->iteration }}</th>
                <th class="text-center fw-normal">
                  <a href="{{ route('admin.class.show', $class->id) }}">
                    {{ $class->name }}
                  </a>
                </th>
                <th class="text-center fw-normal">{{ $class->description }}</th>
                <th class="text-center fw-normal">0</th>
                <th class="text-center fw-normal">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary edit-btn" data-bs-toggle="tooltip" title="{{ __('Chỉnh sửa') }}" data-id="{{ $class->id }}"
                      data-name="{{ $class->name }}" data-description="{{ $class->description }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.class.destroy', $class->id) }}" id="delete_form_{{ $class->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $class->id }}"
                        data-name="{{ $class->name }}" data-bs-toggle="tooltip" title="{{ __('Xóa') }}">
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
      @if ($errors->has('create_error'))
        $('#create-class').modal('show');
      @endif
      @if ($errors->has('edit_error'))
        setEditFormAction({{ old('id') }});
        $('#edit-class').modal('show');
      @endif
    });

    $('.delete-btn').on('click', function(e) {
      e.preventDefault();
      id = $(this).data("id");
      className = $(this).data("name");
      toast.fire({
        title: '{{ __('Xác nhận') }}',
        text: 'Bạn có chắc chắn muốn xóa "' + className + '" và các học sinh trong lớp?',
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

    $('.edit-btn').on('click', function(e) {
        const btn = $(this);
        $('#edit-form input:gt(1)').each(function(idx) {
          $(this).removeClass('is-invalid');
          attr = $(this).attr('name');
          $(this).val(btn.data(attr));
        });
        $('#description').val(btn.data('description'));

        setEditFormAction();
        $('#edit-class').modal('show');
      });

      $('#save_btn').on('click', function(e) {
        e.preventDefault();
        $('#edit-form input:gt(1)').each(function(idx) {
          $(this).prop('disabled', false);
        });
        $('#edit-form').submit();
      })

      function setEditFormAction(classId=null) {
        id = classId ? classId : $("#edit-form input[name='id']").val();
        $('#class-id').val(id);
        url = "{{ route('admin.class.update', ':id') }}";
        url = url.replace(':id', id);
        $('#edit-form').attr('action', url);
      }
  </script>
@endsection
