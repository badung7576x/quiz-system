<html>
<table>
	@switch($type)
		@case(QUESTION_MULTI_CHOICE)
			<thead>
				<tr>
					<th align="center"><b>STT</b></th>
					<th align="center"><b>Câu hỏi</b></th>
					<th align="center"><b>Đáp án 1</b></th>
					<th align="center"><b>Đáp án 2</b></th>
					<th align="center"><b>Đáp án 3</b></th>
					<th align="center"><b>Đáp án 4</b></th>
					<th align="center"><b>Đáp án đúng</b></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $question)
					<tr>
						<td align="left">{{ $loop->iteration }}</td>
						<td align="left">{{ $question->content }}</td>
						@php $correctAns = 0 @endphp
						@foreach ($question->answers as $idx => $answer)
								@php
										if ($answer->is_correct) {
										$correctAns = $idx + 1;
										}
								@endphp
								<td align="left">{{ $answer->content_1 }}</td>
						@endforeach
						<td align="left">{{ $correctAns }}</td>
					</tr>
				@endforeach
			</tbody>
		@break
		@case(QUESTION_TRUE_FALSE)
			<thead>
				<tr>
					<th align="center"><b>STT</b></th>
					<th align="center"><b>Nội dung chính</b></th>
					<th align="center"><b>Câu hỏi đúng/sai</b></th>
					<th align="center"><b>Đáp án</b></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $idx1 => $question)
					@php $newQ = true @endphp
					@foreach ($question->answers as $idx2 => $answer)
						<tr>
							<td align="left">{{ $loop->iteration }}</td>
							@if($newQ) <td align="left" rowspan="{{ count($question->answers) }}" style="vertical-align: middle">{{ $question->content }}</td> @endif
							<td align="left">{{ $answer->content_1 }}</td>
							<td align="left">{{ $answer->is_correct ? 'Đúng' : 'Sai' }}</td>
						</tr>
						@php $newQ = false @endphp
					@endforeach
				@endforeach
			</tbody>
		@break

				@default
		@endswitch
</table>
</html>
