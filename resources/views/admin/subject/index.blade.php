@extends('layouts.admin')

@section('title', 'Môn học')

@section('content')
  {{-- Modal show subject --}}
  <div class="modal" id="show-subject" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Thông tin môn học</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            <table class="table table-borderless table-striped table-vcenter fs-sm" id='subject-table'>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit subject --}}
  <div class="modal" id="edit-subject" tabindex="-1" role="dialog" aria-hidden="true">
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
              <input type="hidden" name="type" value="edit">
              <input type="hidden" name="id" id="subject-id" value="">
              <div class="row mb-2">
                <label class="col-12 col-form-label">Tên môn học <span style="color: red">*</span></label>
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
        <h3 class="block-title">Danh sách môn học</h3>
        <div class="block-options">
          @can('is_admin')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.subject.create') }}" >
              <i class="fa fa-plus"></i>Thêm mới
            </a>
          @endcan
        </div>
      </div>
      <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr style="">
              <th style="width: 6%;" class="text-center">STT</th>
              <th style="width: 20%;" class="text-center">Tên môn học</th>
              <th style="width: 40%;" class="text-center">Mô tả</th>
              <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subjects as $subject)
              <tr>
                <th class="text-center">{{ $loop->iteration }}</th>
                <th class="text-center fw-normal">
                  {{ $subject->name }}
                </th>
                <th class="text-center fw-normal">{{ $subject->description }}</th>
                <th class="text-center fw-normal">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary show-btn" data-bs-toggle="tooltip" title="Xem thông tin" data-id="{{ $subject->id }}">
                      <i class="fa fa-fw fa-eye"></i>
                    </button>
                    <a type="button" class="btn btn-sm btn-alt-secondary" title="Chỉnh sửa" href="{{ route('admin.subject.edit', ['subject' => $subject->id]) }}">
                      <i class="fa fa-fw fa-pencil-alt"></i>
                    </a>
                    @can('is_admin')
                    <form method="POST" action="{{ route('admin.subject.destroy', $subject->id) }}" id="delete_form_{{ $subject->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-sm btn-alt-secondary text-danger delete-btn" data-id="{{ $subject->id }}"
                        data-name="{{ $subject->name }}" data-bs-toggle="tooltip" title="Xóa">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </form>
                    @endcan
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
    const subjects = @json($subjects);

    $('.delete-btn').on('click', function(e) {
      e.preventDefault();
      id = $(this).data("id");
      subject = $(this).data("name");
      toast.fire({
        title: '{{ __('Xác nhận') }}',
        text: 'Bạn có chắc chắn muốn xóa môn học "' + subject + '" không?',
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

    // $('.edit-btn').on('click', function(e) {
    //   const btn = $(this);
    //   $('#edit-form input:gt(1)').each(function(idx) {
    //     $(this).removeClass('is-invalid');
    //     attr = $(this).attr('name');
    //     $(this).val(btn.data(attr));
    //   });
    //   $('#description').val(btn.data('description'));

    //   setEditFormAction();
    //   $('#edit-subject').modal('show');
    // });

    $('.show-btn').on('click', function(e) {
      const subjectId = $(this).data('id');
      const subject = subjects.find(subject => subject.id == subjectId);
      const html = `
        <tbody>
          <tr>
            <td class="fw-semibold" style="width: 30%">Môn học</td>
            <td>${subject.name}</td>
          </tr>
          <tr>
            <td class="fw-semibold" style="width: 30%">Mô tả</td>
            <td>${subject.description ?? ''}</td>
          </tr>
          <tr>
            <td class="fw-semibold align-top" style="width: 30%">Nội dung</td>
            <td>
              ${
                subject.contents.map(content => `${content.order}. ${content.name}`).join('<br>')
              }
            </td>
          </tr>
        </tbody>`;
      $('#subject-table').html(html);
      $('#show-subject').modal('show');
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
      $('#subject-id').val(id);
      url = "{{ route('admin.subject.update', ':id') }}";
      url = url.replace(':id', id);
      $('#edit-form').attr('action', url);
    }
  </script>
@endsection
