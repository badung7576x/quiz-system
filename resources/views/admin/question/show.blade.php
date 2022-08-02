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
            @if($question->status < QUESTION_STATUS_REVIEWED)
              <a class="btn btn-sm btn-info" href="{{ route('admin.question.edit', ['question' => $question->id]) }}">
                <i class="fa fa-pencil-alt"></i> {{ __('Chỉnh sửa') }}
              </a>
            @endif
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
        <div class="row justify-content-center p-4">
          <!-- Form Horizontal - Default Style -->
          <div class="col-12 mb-2">
            <div>
              <span class="fw-bold">Câu hỏi: </span>
              @php
                  $cont = preg_replace('<p>', 'span', $question->content, 1);
                  $cont = preg_replace('</p>', '/span', $cont, 1);
              @endphp
              <span>{!! $cont !!}</span> (<span>{{ $question->score }} điểm</span>)
            </div>
          </div>
          @foreach ($question->answers as $idx => $answer)
            <div class="col-12 ps-5 mb-1">
              <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{{ config('fixeddata.answer_index')[$idx + 1] }}.</span>
              @php
                $ans = preg_replace('<p>', 'span', $answer->content_1, 1);
                $ans = preg_replace('</p>', '/span', $ans, 1);
              @endphp
              <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{!! $ans !!}</span>
            </div>
          @endforeach
          <!-- END Form Horizontal - Default Style -->
          <div class="col-12 mt-4">
            <table class="table-borderless table-striped table-vcenter fs-sm table">
              <tbody>
                <tr>
                  <td class="fw-semibold" style="width: 30%">Phạm vi câu hỏi</td>
                  <td>{{ $question->subject_content?->name ?? '' }}</td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%">Độ khó</td>
                  <td>{{ config('fixeddata.question_level')[$question->level] }}</td>
                </tr>
                <tr>
                  <td class="fw-semibold" style="width: 30%">Ngày tạo</td>
                  <td>{{ $question->created_at }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <form method="POST" action="{{ route('admin.question.destroy', ['question' => $question->id]) }}" id="delete_form">
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
                    @php $avatar = $comment->commentor->avatar != '' ? $comment->commentor->avatar : asset('images/default_avatar.png') @endphp
                    <img class="img-avatar img-avatar32" style="margin-left: 3px" src="{{ $avatar }}" alt="">
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
                            @if (auth()->user()->id == $comment->created_by || auth()->user()->id == $question->created_by)
                              <i class="far fa-check-circle me-2" style="cursor: pointer" onclick="resolvedComment({{ $comment->id }})"></i>
                            @endif
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
  <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
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
          $('form#delete_form').submit();
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
