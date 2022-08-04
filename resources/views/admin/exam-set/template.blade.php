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

				.col-2 {
						flex: 0 0 auto;
						width: 20%;
				}

				.col-10 {
						flex: 0 0 auto;
						width: 80%;
				}

				.box {
						width: fit-content;
						height: fit-content;
						border: 2px solid #000;
						padding: 5px 25px;
						font-size: 16px;
						margin-top: 10px !important;
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

				.text-left {
						text-align: left;
				}

				.f-right {
						float: right;
				}

				.f-left {
						float: left;
				}
		</style>

</head>

<body>
		@php $setting = $examSet->setting; @endphp
		@if ($setting && $setting->is_display_top)
				<div class="row" style="font-size:20px">
						<div class="col-6 f-left text-center">
								@php
										$top_left = preg_replace('{code}', '<div class="box-center box"> Mã đề thi <br>' . $examSetDetail->code . '</div>', $setting->top_left, 1);
								@endphp
								{!! $top_left !!}
						</div>
						<div class="col-6 f-right text-center">
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
										<span class="text-bold">Câu {{ $loop->iteration }}:</span>
										<span>{!! $question->content !!}</span>
								</div>
						</div>
				</div>
				<div class="row" style="padding: 2px 40px; margin-bottom: 10px">
						@switch($question->type)
								@case(QUESTION_MULTI_CHOICE)
										@foreach ($question->answers as $idx2 => $answer)
												<div class="{{ $question->format }}">
														<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
														<span>{!! $answer['content_1'] !!}</span>
												</div>
										@endforeach
								@break

								@case(QUESTION_TRUE_FALSE)
										@foreach ($question->answers as $idx2 => $answer)
												<div class="col-10">
														<span class="">{{ $idx2 + 1 }}.</span>
														<span>{!! $answer['content_1'] !!}</span>
												</div>
												<div class="col-2">
													<span class="f-right">.....</span>
											</div>
										@endforeach
								@break

								@default
						@endswitch
				</div>
		@endforeach
		@if ($setting && $setting->is_display_bottom)
				<div class="row text-center" style="margin: 60px 0">
						<div class="col-12">
								{!! $setting->bottom !!}
						</div>
				</div>
		@endif


		<br>
		<br>
		<br>
		<hr>
		<br>
		<br>
		<div class="row text-center" style="margin: 5px 0">
				<div class="col-12" style="margin-bottom: 15px">
						<span class="text-bold text-underline">ĐÁP ÁN</span>
				</div>
				<br>
				@foreach ($questions as $idx => $question)
						<div class="col-3 text-left">
								<span class="text-bold">Câu {{ $loop->iteration }}: </span>
								<span>{{ $question->correct_answer }}</span>
						</div>
				@endforeach
		</div>
		<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
</body>

</html>
