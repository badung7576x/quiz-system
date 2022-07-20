@extends('layouts.admin')

@section('title', __('Đề thi'))

@section('content')
  <div class="content content-full" style="max-width: 1920px">
    <div class="row">
      <div class="col-3 end-0">
        <div class="block block-rounded pb-2">
          <div class="block-header block-header-default">
            <h3 class="block-title">Thông tin bộ đề thi</h3>
          </div>
          <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter fs-sm">
              <tbody>
                <tr>
                  <td class="fw-semibold" style="width: 30%">Môn thi</td>
                  <td>{{ $examSet->subject->name }}</td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%">Nội dung</td>
                  <td>
                    @foreach($examSet->subjectContents as $content)
                      <span class="badge bg-success">{{ $content }}</span>
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%"> Số lượng <br>câu hỏi </td>
                  <td>{{ $examSet->total_question }} câu hỏi</td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%"> Thời gian <br>làm bài </td>
                  <td>{{ $examSet->execute_time }} phút</td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%"> Loại đề thi</td>
                  <td><span class="badge bg-success">{{ config('fixeddata.exam_set_type')[$examSet->type] }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="block block-rounded pb-2">
          <div class="block-header block-header-default">
            <h3 class="block-title">Danh sách đề thi</h3>
          </div>
          <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter fs-sm">
              <tbody>
                @foreach ($examSet->examSetDetails as $index => $detail)
                <tr>
                  <td class="fw-semibold" style="width: 30%">Đề thi {{ $index + 1 }}</td>
                  <td><a href="{{ route('admin.exam-set.pdf', ['exam_set' => $examSet->id, 'exam_set_detail' => $detail->id]) }}" target="exam-iframe" onclick="changeDownloadHref({{ $examSet->id }}, {{ $detail->id }})">{{ $detail->code }}  </a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-9">
        <div class="block block-rounded">
          <div class="block-header block-header-default">
            <h3 class="block-title">Đề thi</h3>
            <div class="block-options">
              <a href="{{ route('admin.exam-set.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left"></i> Quay lại
              </a>
              <a href="{{ route('admin.exam-set.setting', ['exam_set' => $examSet->id]) }}" class="btn btn-sm btn-outline-primary">
                <i class="fa fa-cogs"></i> Cài đặt
              </a>
              <a id="download_link" href="{{ route('admin.exam-set.download', ['exam_set' => $examSet->id, 'exam_set_detail' => $examSet->examSetDetails[0]->id]) }}" target="_blank" class="btn btn-sm btn-outline-success">
                <i class="fa fa-file-download"></i> Tải xuống
              </a>
              <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger delete-btn">
                <i class="fa fa-trash"></i> Xóa bộ đề
              </a>
              <form method="POST" action="{{ route('admin.exam-set.destroy', ['exam_set' => $examSet->id]) }}" id="delete_form">
                @csrf
                @method('delete')
              </form>
            </div>
          </div>
          <div class="block-content">
            <iframe name="exam-iframe" src="{{ route('admin.exam-set.pdf', ['exam_set' => $examSet->id, 'exam_set_detail' => $examSet->examSetDetails[0]->id]) }}" frameborder="0" style="width: 100%; height: 80vh;"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js_after')
  <script src="https://cdn.ckeditor.com/4.18.0/standard-all/ckeditor.js"></script>
  <script>
    $(document).ready(function() {
      initCkeditor();
    });

    function initCkeditor() {
      $(".ckeditor1").each(function(_, ckeditor) {
        CKEDITOR.replace(ckeditor, {
          toolbar: [{
              name: 'clipboard',
              items: ['Undo', 'Redo']
            },
            {
              name: 'basicstyles',
              items: ['Bold', 'Italic', 'Underline', 'Strike', 'CopyFormatting', 'RemoveFormat']
            },
            {
              name: 'paragraph',
              items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            {
              name: 'links',
              items: ['Link', 'Unlink']
            },
            {
              name: 'insert',
              items: ['Image', 'Table', 'Mathjax']
            },
            {
              name: 'colors',
              items: ['TextColor', 'BGColor']
            },
            {
              name: 'tools',
              items: ['Maximize']
            },
          ],
          extraPlugins: 'mathjax',
          mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
          removeButtons: 'PasteFromWord'
        })
      });
    }

    $('.delete-btn').on('click', function(e) {
      e.preventDefault();
      toast.fire({
        title: '{{ __('Xác nhận') }}',
        text: 'Bạn có chắc chắn muốn xóa bộ đề thi này không ?',
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
          $('#delete_form').submit();
        }
      });
    });

    function changeDownloadHref(id, detailId) {
      let href = "{{ route('admin.exam-set.pdf', ['exam_set' => ':exId', 'exam_set_detail' => ':detailId']) }}"
      href = href.replace(':exId', id)
      href = href.replace(':detailId', detailId)
      $('#download_link').attr("href", href)
    } 
  </script>
@endsection
