<html>
<table>
  <thead>
    {{-- <tr>
      @php $numCols = 6  @endphp
      @php $border = "border: 3px solid black;" @endphp
      @php $header = "color: white; background: #4c78dd;" @endphp
      <th align="center" colspan="{{ $numCols }}" style="font-size: 14px; {{ $border }}" height="25"><b>Danh sách câu hỏi</b></th>
    </tr>
    <tr>
      <th colspan="{{ $numCols }}" style="{{ $border }}"></th>
    </tr> --}}
    <tr>
      {{-- <th align="center" rowspan="2" style="{{ $header . $border }}"></th> --}}
      <th align="center" ><b>STT</b></th>
      <th align="center" ><b>Câu hỏi</b></th>
      <th align="center" ><b>Đáp án 1</b></th>
      <th align="center" ><b>Đáp án 2</b></th>
      <th align="center" ><b>Đáp án 3</b></th>
      <th align="center" ><b>Đáp án 4</b></th>
      <th align="center" ><b>Đáp án đúng</b></th>
      <th align="center" ><b>Thời gian tạo</b></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $question)
      <tr>
        <td align="left">{{ $loop->iteration }}</td>
        <td align="left">{{ $question->content }}</td>
        @php $correctAns = 0 @endphp
        @foreach ($question->answers as $idx => $answer)
          @php if ($answer->is_correct) $correctAns = $idx + 1 @endphp
          <td align="left">{{ $answer->content_1 }}</td>
        @endforeach
        <td align="left">{{ $correctAns }}</td>
        <td align="left">{{ $question->created_at }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

</html>
