<hr>
@foreach($duplicateQuestions as $num => $q)
  <div class="row mt-2 mb-4" style="font-size: 18px">
    <div class="col-12">
      <div>
        <span style="font-weight: 600">Câu hỏi {{ $num + 1}}: </span>
        <span>{!! $q->content !!}</span>
      </div>
    </div>
    @if($question->image)
      <div class="col-12 mb-2">
        <div class="" style="height: 350px">
          <img src="{{ $question->image }}" style="max-width: 100%; max-height: 100%">
        </div>
      </div>
    @endif
    @switch($q->type)
      @case(QUESTION_MULTI_CHOICE)
        @foreach ($q->answers as $idx => $answer)
          <div class="col-12 ps-5 mb-1">
            <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{{ config('fixeddata.answer_index')[$idx + 1] }}.</span>
            <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{!! $answer->content_1 !!}</span>
          </div>
        @endforeach
        @break
      @case(QUESTION_TRUE_FALSE)
        <table class="table table-bordered ms-3 mt-2" style="width: 95%">
          <tbody>
            @foreach ($q->answers as $idx => $answer)
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
@endforeach

<div class="h5 text-danger text-center">
  Câu hỏi có thể bị trùng lặp với một số câu hỏi trên đây. <br>Bạn có muốn tiếp tục thêm câu hỏi vào ngân hàng đề thi không?
</div>

<div class="row mt-2 mb-4" style="font-size: 18px">
  <div class="col-12 text-center">
    <button class="btn btn-sm btn-outline-success" onclick="approvedQuestion({{ $question->id }}, true)">
      <i class="fa fa-check-circle"></i> {{ __('Xác nhận') }}
    </button>
    <button class="btn btn-sm btn-outline-danger" onclick="rejectQuestion({{ $question->id }})">
      <i class="fa fa-ban"></i> {{ __('Từ chối') }}
    </button>
  </div>
</div>
