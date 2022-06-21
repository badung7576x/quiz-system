<div class="row">
		<div class="col-12">
				<div>
						<span class="text-bold">Câu hỏi:</span>
						@php
								$cont = preg_replace('<p>', 'span', $question->content, 1);
								$cont = preg_replace('</p>', '/span', $cont, 1);
						@endphp
						<span>{!! $cont !!}</span>
				</div>
		</div>
</div>
<div class="row" style="padding: 2px 40px; margin-bottom: 10px">
		@foreach ($question->answers as $idx2 => $answer)
				<div class="{{ $question->format }}">
						<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
						@php
								$ans = preg_replace('<p>', 'span', $answer['content'], 1);
								$ans = preg_replace('</p>', '/span', $ans, 1);
						@endphp
						<span>{!! $ans !!}</span>
				</div>
		@endforeach
</div>
