<div class="row mt-2 mb-4" style="font-size: 18px">
  <div class="col-12">
    <div>
      <span style="font-weight: 600">Câu hỏi: </span>
      @php
          $cont = preg_replace('<p>', '', $question->content, 1);
          $cont = preg_replace('</p>', '', $cont, 1);
      @endphp
      <span>{!! $cont !!}</span> (<span>{{ $question->score }} điểm</span>)
    </div>
  </div>
  @foreach ($question->answers as $idx => $answer)
    <div class="col-12 ps-5">
      <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{{ config('fixeddata.answer_index')[$idx + 1] }}.</span>
      @php
        $ans = preg_replace('<p>', '', $answer->content_1, 1);
        $ans = preg_replace('</p>', '', $ans, 1);
      @endphp
      <span class="{{ $answer->is_correct ? 'fw-bold text-success' : '' }}">{!! $ans !!}</span>
    </div>
  @endforeach
</div>

<div class="row" style="font-size: 18px">
  <div class="col-12">
    <table class="table-borderless table-striped table-vcenter fs-sm table">
      <tbody>
        <tr>
          <td class="fw-semibold" style="width: 30%">Nội dung môn học</td>
          <td>{{ $question->subject_content->name }}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Người tạo</td>
          <td>{{ $question->teacher->fullname }}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Người đánh giá</td>
          <td>{{ $question->reviewer->fullname }}</td>
        </tr>
        <tr>
          <td class="fw-semibold" style="width: 30%">Ngày tạo</td>
          <td>{{ $question->created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
