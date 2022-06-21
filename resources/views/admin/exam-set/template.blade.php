<!DOCTYPE html>
<html lang="en">

<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Đề thi</title>
		<style>
				* {
						margin: 0;
						padding: 0
				}

				body {
						font-size: 18px;
						color: #000;
						font-family: lora, "Times New Roman", Times, serif;
						margin: 20px 100px;
						margin-top: 50px;
				}

				div {
						padding-bottom: 5px;
				}

				.row {
						margin-right: 0;
						margin-left: 0;
						display: flex;
						flex-wrap: wrap;
				}

				.col-12 {
						flex: 0 0 100%;
						max-width: 100%;
				}

				.col-6 {
						flex: 0 0 auto;
						width: 50%;
				}

				.col-3 {
						flex: 0 0 auto;
						width: 25%;
				}

				.box {
						width: fit-content;
						height: fit-content;
						border: 2px solid #000;
						padding: 10px;
				}

				.box-center {
						margin: auto;
				}

				.text-bold {
						font-weight: bold;
				}

				.text-underline {
						text-decoration: underline;
				}

				.text-center {
						text-align: center;
				}
		</style>

</head>

<body>
		@php $setting = $examSet->setting; @endphp
		@if ($setting && $setting->is_display_top)
				<div class="row" style="font-size:20px">
						<div class="col-6 text-center">
								{!! $setting->top_left !!}
						</div>
						<div class="col-6 text-center">
								@php
										$top_right = preg_replace('{subject}', $examSet->subject->name, $setting->top_right, 1);
								@endphp
								{!! $top_right !!}
						</div>
				</div>
		@endif

		@if ($setting && $setting->is_display_center)
				<div class="row text-center" style="margin: 40px 0">
						<div class="col-12">
								{!! $setting->center !!}
						</div>
				</div>
		@endif

		<div class="row text-center" style="margin: 5px 0">
				<div class="col-12">
						<div class="text-bold text-underline">
								ĐỀ THI
						</div>
				</div>
		</div>
		@php $questions = $examSet->questions @endphp
		@foreach ($questions as $idx => $question)
				<div class="row">
						<div class="col-12">
								<div>
										<span class="text-bold">Câu {{ $idx + 1 }}:</span>
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
		@endforeach
		@if ($setting && $setting->is_display_bottom)
				<div class="row text-center" style="margin: 60px 0">
						<div class="col-12">
								{!! $setting->bottom !!}
						</div>
				</div>
		@endif
		<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
</body>

</html>