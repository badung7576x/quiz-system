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
                <div class="block-content block-content-full text-center bg-success">
                  <div class="item item-2x item-circle py-3 my-3 mx-auto bg-white-10">
                    <span style="font-size:30px;font-weight:800;color:white">{{ $examSet->subject->name[0] }}</span>
                  </div>
                  <div class="fs-sm text-white-75">
                    {{ $examSet->total_question }} câu hỏi • {{ $examSet->execute_time }} phút
                  </div>
                </div>
                <div class="block-content block-content-full">
                  <h4 class="h5 mb-1">
                    <a href="{{ route('admin.exam-set.show', ['exam_set' => $examSet->id]) }}">{{ $examSet->name }}</a>
                  </h4>
                  <div class="fs-sm text-muted">{{ $examSet->created_at }}</div>
                  <div class="mt-2">
                    <span class="badge bg-success">{{ config('fixeddata.exam_set_type')[$examSet->type] }}</span>
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
    function randomBgPanel() {
      const color = [
        'bg-city-10',
        'bg-flat-10',
        'bg-amethyst-10',
        'bg-smooth-10',
        'bg-default-10',
        'bg-modern-10',
        'bg-warning-10',
        'bg-success-10',
        'bg-info-10',
        'bg-danger-10',
        'bg-gray-dark-10',
        'bg-primary-10'
      ];

      return color[2];
    }
  </script>
@endsection
