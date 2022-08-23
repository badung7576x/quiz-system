<div class="row mt-2 mb-4" style="font-size: 18px">
  <div class="col-12">
    <div>
      <span style="font-weight: 600">Câu hỏi: </span>
      <span>{!! $question->content !!}</span> (<span>{{ $question->score }} điểm</span>)
    </div>
  </div>
  @switch($question->type)
    @case(QUESTION_MULTI_CHOICE)
      @foreach ($question->answers as $idx => $answer)
        <div class="col-12 ps-5 mb-1">
          <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{{ config('fixeddata.answer_index')[$idx + 1] }}.</span>
          <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{!! $answer->content_1 !!}</span>
        </div>
      @endforeach
      @break
    @case(QUESTION_SHORT_ANSWER)
      @foreach ($question->answers as $idx => $answer)
        <div class="col-12 ps-5 mb-1">
          <span class="">Đáp án: </span>
          <span class="">{!! $answer->content_1 !!}</span>
        </div>
      @endforeach
      @break
    @case(QUESTION_TRUE_FALSE)
      <table class="table table-bordered ms-3 mt-2" style="width: 95%">
        <tbody>
          @foreach ($question->answers as $idx => $answer)
            <tr class="odd">
              <td class="text-center" style="width: 5%">{{ $idx + 1 }}</td>
              <td class="fs-sm">{!! $answer->content_1 !!}</td>
              <td class="fs-sm text-center" style="width: 10%">
                {!! $answer->is_correct ? '<span class="text-success">Đúng</span>' : '<span class="text-danger">Sai</span>' !!}
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>                
      @break
    @default
  @endswitch
</div>

<div class="row" style="font-size: 18px">
  <div class="col-12">
    <table class="table-borderless table-striped table-vcenter fs-sm table">
      <tbody>
        <tr>
          <td class="fw-semibold" style="width: 30%">Nội dung môn học</td>
          <td>{{ $question->subject_content->name ?? '' }}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Người tạo</td>
          <td>{{ $question->teacher->fullname ?? ''}}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Người đánh giá</td>
          <td>{{ $question->reviewer->fullname ?? ''}}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Ngày tạo</td>
          <td>{{ $question->created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
