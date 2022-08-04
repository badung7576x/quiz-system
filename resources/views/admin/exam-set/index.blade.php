@extends('layouts.admin')

@section('title', __('Trang quản trị'))

@section('content')
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách đề thi</h3>
        <div class="block-options">
          <a href="{{ route('admin.exam-set.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          @foreach($examSets as $examSet)
            <div class="col-sm-6 col-md-4 col-xl-2 col-lg-3">
              <div class="block block-rounded bg-gray-light">
                <div class="block-content bg-flat-light" style="padding: 6px 0">
                  {!! render_es_status($examSet->status) !!}
                </div>
                <div class="block-content block-content-full text-center bg-flat-light">
                  <div class="item item-2x item-circle py-3 my-3 mx-auto bg-white-10">
                    <i class="fa fa-file-alt fa-2x text-white-75"></i>
                  </div>
                  <div class="fs-sm text-gray-25">
                    {{ $examSet->total_question }} câu hỏi • {{ $examSet->execute_time }} phút
                  </div>
                </div>
                <div class="block-content block-content-full">
                  <h4 class="h5 mb-1">
                    @if($examSet->status == EXAM_SET_STATUS_APPROVED)
                      <a href="{{ route('admin.exam-set.show', ['exam_set' => $examSet->id]) }}">{{ $examSet->name }}</a>
                    @else
                      {{ $examSet->name }}
                    @endif
                  </h4>
                  <div class="fs-sm text-muted">{{ $examSet->created_at }}</div>
                  <div class="mt-2">
                    <span class="badge bg-primary">{{ config('fixeddata.exam_set_type')[$examSet->type] }}</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js_after')
  <script>
    function randomBgPanel(status) {
      if(status == 1) {
        return 'bg-flat';
      }
      if(status == 2) {
        return 'bg-success';
      }
      if(status == 3) {
        return 'bg-city';
      }
    }
  </script>
@endsection
