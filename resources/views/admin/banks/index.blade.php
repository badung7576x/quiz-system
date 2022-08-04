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


  <div class="modal" id="choose-type-export" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Hình thức tải xuống</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            <div class="mb-4">
              <label class="form-label">Định dạng file tải xuống</label>
              <div class="space-y-2">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="type1" name="type" value="excel" checked="">
                  <label class="form-check-label" for="type1">Định dạng Excel</label>
                </div>
                {{-- <div class="form-check">
                  <input class="form-check-input" type="radio" id="type2" name="type" value="csv">
                  <label class="form-check-label" for="type2">Định dạng CSV</label>
                </div> --}}
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="type3" name="type" value="aiken">
                  <label class="form-check-label" for="type3">Định dạng Aiken (Sử dụng cho hệ thống Moodle)<br><small class="text-danger">※ Chỉ hỗ trợ câu hỏi dạng "Trắc nghiệm nhiều lựa chọn"</small></label>
                </div>
                {{-- <div class="form-check">
                  <input class="form-check-input" type="radio" id="type3" name="type" value="option2" disabled="">
                  <label class="form-check-label" for="type3">Option 3</label>
                </div> --}}
              </div>
            </div>
          </div>
          <div class="block-content block-content-full text-end bg-body">
            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Hủy</button>
            <button class="btn btn-sm btn-outline-success" onclick="exportListQuestion()"><i class="fa fa-download me-1"></i>Tải xuống</button>
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
          <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#choose-type-export"> 
            <i class="fa fa-download"></i> Tải xuống bộ câu hỏi
          </button>
        </div>
      </div>
      <div class="block-content border-bottom">
        <form id="filter-form" action="{{ route('admin.question-bank.index') }}" method="GET">
          <input type="hidden" name="ids" id="listIds" value="">
          <input type="hidden" name="export_type">
          <div class="push">
            <div class="row">
              {{-- <div class="col-12">
                <label class="form-label">Nội dung câu hỏi</label>
                <textarea class="form-control" name="content" placeholder="Nhập nội dung câu hỏi">{{ request()->content ?? '' }}</textarea>
              </div> --}}
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
              <div class="col-6 mt-2">
                <label class="form-label">Loại câu hỏi</label>
                <select class="js-select2 form-select" name="question_types[]" id="qt" multiple data-placeholder="Lựa chọn loại câu hỏi" style="width: 100%">
                  @foreach(config('fixeddata.question_type') as $key => $type)
                    <option value="{{ $key }}" @selected(in_array($key, request()->question_types ?? []))>{{ $type }}</option>
                  @endforeach
                </select>
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
          <table class="table table-striped table-vcenter js-dataTable-full" id="question-table">
            <thead>
              <tr style="">
                <th style="width: 6%;" class="text-center"></th>
                <th style="width: 50%;" class="text-center">Câu hỏi</th>
                <th style="width: 20%;" class="text-center">Nội dung</th>
                <th style="width: 10%;" class="text-center">Loại câu hỏi</th>
                <th style="width: 14%;" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center">
                    <input type="checkbox" class="form-check-input" name="question_id" value="{{ $question->id }}">
                  </td>
                  <td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
                  <td style="max-width: 250px" class="text-truncate">{{ $question->subject_content->name }}</td>
                  <td class="text-center">{{ config('fixeddata.question_type')[$question->type] }}</td>
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
      $(".js-select2").val('').trigger('change');
      // window.location.href = "{{ route('admin.question-bank.index') }}"
    }

    const filterData = () => {
      $('#filter-form').attr('action', '{{ route('admin.question-bank.index') }}');
      $('#filter-form').submit();
    }

    function exportListQuestion() {
      $('input[name="export_type"]').val($('input[name=type]:checked').val());
      const questionIds = [];
      $('input[name="question_id"]:checked').each(function() {
        questionIds.push($(this).val());
      });
      $('#listIds').val(questionIds);
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
