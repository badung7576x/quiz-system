@extends('layouts.admin')

@section('title', __('Câu hỏi'))

@section('content')
  <!-- Page Content -->

  <!-- Horizontal -->
  <div class="content content-boxed">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Thông tin câu hỏi</h3>
        <div class="block-options">
          <a href="{{ route('admin.question.index') }}" class="btn btn-sm btn-dark">
            <i class="fa fa-arrow-left"></i> {{ __('Quay lại') }}
          </a>
          @if (auth()->user()->id == $question->created_by)
            <a class="btn btn-sm btn-info" href="{{ route('admin.question.edit', ['question' => $question->id]) }}">
              <i class="fa fa-pencil-alt"></i> {{ __('Chỉnh sửa') }}
            </a>
            <a class="btn btn-sm btn-danger" href="#" onclick="deleteQuestion()">
              <i class="fa fa-trash"></i> {{ __('Xóa') }}
            </a>
          @endif
          @if (auth()->user()->id == $question->review_by && $question->status == QUESTION_STATUS_WAITING_REVIEW)
            <a class="btn btn-sm btn-success" 
              href="{{ route('admin.question.review', ['question' => $question->id]) . "?status=" . QUESTION_STATUS_REVIEWED }}">
              <i class="fa fa-check-circle"></i> {{ __('Xác nhận') }}
            </a>
            <a class="btn btn-sm btn-danger" 
              href="{{ route('admin.question.review', ['question' => $question->id]) . "?status=" . QUESTION_STATUS_REJECTED }}">
              <i class="fa fa-ban"></i> {{ __('Từ chối') }}
            </a>
          @endif
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row justify-content-center">
          <!-- Form Horizontal - Default Style -->
          <div class="col-12">
            <div class="row">
              <div class="col-12 my-2 mt-0">
                <span class="h4">Môn học: </span>
                <span class="h5 fw-normal">{{ $question->subject->name }}</span> -
                <span class="h5 fw-normal">{{ $question->subject_content->name }}</span>
              </div>
              <div class="col-12 my-2">
                <span class="h4">Dạng câu hỏi: </span>
                <span class="h5 fw-normal">{{ config('fixeddata.question_type')[$question->type] }}</span>
              </div>
              <div class="col-12 my-2">
                <span class="h4">Loại câu hỏi: </span>
                <span class="h5 fw-normal">{{ config('fixeddata.question_level')[$question->level] }}</span>
              </div>
              <div class="col-12 my-2 mb-3">
                <span class="h4">Trạng thái: </span>
                <span class="h5 badge bg-black-50">Tạo mới</span>
              </div>
            </div>
          </div>
          <hr>
          <div class="col-12 pb-1">
            <span class="h4">Câu hỏi:</span>
            <span class="h4 fw-normal">{{ ' (' . $question->score . __(' điểm)') }}</span>
            <div class="h4 fw-normal bg-gray-light p-3">{!! $question->content !!}</div>
            <hr>
          </div>
          @foreach ($question->answers as $answer)
            @php $no = $loop->iteration @endphp
            <div class="col-12">
              <span class="h4 fw-semibold">{{ __('Đáp án') }} {{ $no }} {{ $answer->is_correct ? '(đáp án đúng)' : '' }}</span>
              <div class="h4 fw-normal {{ $answer->is_correct ? 'bg-success-light' : 'bg-gray-light' }} p-3 mt-2">
                {!! $answer->content_1 !!}
              </div>
            </div>
          @endforeach
          <!-- END Form Horizontal - Default Style -->
        </div>
        <form method="POST" action="{{ route('admin.question.destroy', ['question' => $question->id]) }}" id="delete_form_{{ $question->id }}">
          @csrf
          @method('delete')
        </form>
      </div>
    </div>
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Nhận xét</h3>
        <div class="block-options">
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="col-md-12">
          @if (count($comments) > 0)
            <ul class="timeline timeline-alt py-0">
              @foreach ($comments as $comment)
                <li class="timeline-event">
                  <div class="timeline-event-icon">
                    <img class="img-avatar img-avatar32" style="margin-left: 3px" src="{{ asset('/images/default_avatar.png') }}" alt="">
                  </div>
                  <div class="timeline-event-block block">
                    <div class="block-header">
                      <div class="">
                        <span class="text-primary-darker">{{ $comment->commentor->fullname }}</span>
                        <span class="text-gray-dark">({{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }})</span>
                      </div>
                      <div class="block-options">
                        <div class="timeline-event-time block-options-item fs-4">
                          @if ($comment->is_resolved)
                            <i class="fa fa-check-circle text-success me-2"></i>
                          @else
                            <i class="far fa-check-circle me-2" style="cursor: pointer" onclick="resolvedComment({{ $comment->id }})"></i>
                          @endif
                          {{-- <i class="far fa-comment-dots me-2" style="cursor: pointer" onclick="replyCpmment({{ $comment->id }})"></i> --}}
                          @if (auth()->user()->id == $comment->created_by)
                            <div class="dropdown">
                              <i class="fa fa-ellipsis-h" style="cursor: pointer" data-bs-toggle="dropdown"></i>
                              <div class="dropdown-menu fs-sm" style="min-width: 100px">
                                <a class="dropdown-item" style="cursor: pointer" onclick="editComment({{ $comment->id }})" >Sửa</a>
                                <a class="dropdown-item" style="cursor: pointer" onclick="deleteComment({{ $comment->id }})">Xóa</a>
                                <form id="delete_comment_{{ $comment->id }}" method="POST"
                                  action="{{ route('admin.comment.destroy', ['question' => $question->id, 'comment' => $comment->id]) }}">
                                  @csrf
                                  @method('delete')
                                </form>
                              </div>
                            </div>
                          @endif
                          <form id="resolved_comment_{{ $comment->id }}" method="POST"
                            action="{{ route('admin.comment.resolved', ['question' => $question->id, 'comment' => $comment->id]) }}">
                            @csrf
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="block-content pt-0">
                      <div class="edit_comment_{{ $comment->id }} bg-gray-light p-2">
                        {!! $comment->content !!}
                      </div>
                      <div class="edit_comment_{{ $comment->id }} pt-3 d-none">
                        <form method="POST" action="{{ route('admin.comment.update', ['question' => $question->id, 'comment' => $comment->id]) }}">
                          @csrf
                          @method('PUT')
                          <textarea class="ckeditor1 form-control" name="comment">{!! old('comment', $comment->content) !!}</textarea>
                          <div class="pt-2">
                            <button type="submit" class="btn btn-sm btn-success">
                              Cập nhật
                            </button>
                          </div>
                        </form>
                      </div>
                      <div id="reply_comment_{{ $comment->id }}" class="pt-3 d-none">
                        <textarea class="ckeditor1 form-control" name="comment"></textarea>
                        <div class="pt-2">
                          <button type="submit" class="btn btn-sm btn-success">
                            Nhận xét
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          @else
            <div class="m-3 alert alert-info">
              {{ __('Chưa có nhận xét nào') }}
            </div>
          @endif
          <!-- END Updates -->
        </div>
        <div class="col-md-12 p-3">
          <hr>
          <div class="fw-semibold">Thêm nhận xét mới</div>
          <form method="POST" action="{{ route('admin.comment.store', ['question' => $question->id]) }}">
            @csrf
            <textarea class="ckeditor1 form-control" name="new_comment">{{ old('new_comment') }}</textarea>
            <div class="pt-2">
              <button type="submit" class="btn btn-sm btn-success">
                Nhận xét
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- END Horizontal -->
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

    function deleteQuestion() {
      showConfirmModal()
    }

    function showConfirmModal() {
      toast.fire({
        title: '{{ __('Xác nhận') }}',
        text: '{{ __('Bạn chắc chắn muốn xóa câu hỏi này?') }}',
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
      }).then((result) => {
        if (result.isConfirmed) {
          $('form#delete-form').submit();
        }
      })
    }

    function resolvedComment(id) {
      $('#resolved_comment_' + id).submit();
    }

    function deleteComment(id) {
      $('#delete_comment_' + id).submit();
    }

    function replyCpmment(id) {
      $('#reply_comment_' + id).toggleClass('d-none');
    }

    function editComment(id){
      $('.edit_comment_' + id).toggleClass('d-none');
    }


  </script>
@endsection
