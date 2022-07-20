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
            <i class="fa fa-check-square"></i> Câu hỏi chờ duyệt ({{ $numOfWaiting }})
          </a>
          <a href="#" class="btn btn-outline-primary btn-sm" onClick="exportListQuestion()">
            <i class="fa fa-download"></i> Tải xuống bộ câu hỏi
          </a>
        </div>
      </div>
      <div class="block-content border-bottom">
        <form id="filter-form" action="{{ route('admin.question-bank.index') }}" method="GET">
          <div class="push">
            <div class="row">
              <div class="col-6">
                <label class="form-label">Nội dung môn học</label>
                <select class="js-select2 form-select" name="subject_content_ids[]" id="sc" multiple data-placeholder="Lựa chọn nội dung" style="width: 100%">
                  @foreach($subjectContents as $content)
                    <option value="{{ $content->id }}" @selected(in_array($content->id, request()->subject_content_ids ?? []))>{{ $content->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-3">
                <label class="form-label">Thời gian tạo</label>
                <input type="text" class="js-flatpickr form-control col-6" name="from" data-date-format="d-m-Y" placeholder="Từ ngày" value="{{ request()->from ?? '' }}">
              </div>
              <div class="col-3">
                <label class="form-label">　　　　</label>
                <input type="text" class="js-flatpickr form-control col-6" name="to" data-date-format="d-m-Y" placeholder="Đến ngày" value="{{ request()->to ?? '' }}">
              </div>
            </div>
          </div>
          <div class="row py-3">
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-sm btn-alt-success me-2" onclick="filterData()">
                <i class="fa fa-filter"></i> Lọc dữ liệu
              </button>
              <button type="reset" class="btn btn-sm btn-alt-secondary" onclick="clearSearch()">
                <i class="fa fa-trash"></i> Xóa bộ lọc
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter js-dataTable-full" id="exam-table">
            <thead>
              <tr style="">
                <th style="width: 6%;" class="text-center">STT</th>
                <th style="width: 50%;" class="text-center">Câu hỏi</th>
                <th style="width: 20%;" class="text-center">Nội dung</th>
                <th style="width: 10%;" class="text-center">Thời gian tạo</th>
                <th style="width: 14%;" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
                  <td style="max-width: 250px" class="text-truncate">{{ $question->subject_content->name }}</td>
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

@section('css_before')
  <link rel="stylesheet" href="{{ asset('/js/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
  <script src="{{ asset('/js/plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script>
    One.helpersOnLoad(['jq-select2', 'js-flatpickr']);
    
    $(".js-select2").select2({
      language: {
        noResults: function() {
          return "Không có dữ liệu";
        }
      }
    });

    const clearSearch = () => {
      // $(".js-select2").val('').trigger('change');
      window.location.href = "{{ route('admin.question-bank.index') }}"
    }

    const filterData = () => {
      $('#filter-form').attr('action', '{{ route('admin.question-bank.index') }}');
      $('#filter-form').submit();
    }

    function exportListQuestion() {
      $('#filter-form').attr('action', '{{ route('admin.question-bank.export') }}');
      $('#filter-form').submit();
    }

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
