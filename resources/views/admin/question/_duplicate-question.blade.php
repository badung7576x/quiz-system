<hr>
@foreach($duplicateQuestions as $num => $q)
  <div class="row mt-2 mb-4" style="font-size: 18px">
    <div class="col-12">
      <div>
        <span style="font-weight: 600">Câu hỏi {{ $num + 1}}: </span>
        @php
            $cont = preg_replace('<p>', 'span', $q->content, 1);
            $cont = preg_replace('</p>', '/span', $cont, 1);
        @endphp
        <span>{!! $cont !!}</span>
      </div>
    </div>
    @foreach ($q->answers as $idx => $answer)
      <div class="col-12 ps-5">
        <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{{ config('fixeddata.answer_index')[$idx + 1] }}.</span>
        @php
          $ans = preg_replace('<p>', 'span', $answer->content_1, 1);
          $ans = preg_replace('</p>', '/span', $ans, 1);
        @endphp
        <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{!! $ans !!}</span>
      </div>
    @endforeach
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
