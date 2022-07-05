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
						font-size: 14px;
						color: #000;
						font-family: lora, "Times New Roman", Times, serif;
						margin: 10px 50px;
						margin-top: 50px;
						height: 50px;
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
						width: 100px;
						height: fit-content;
						border: 1px solid #000;
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

				.f-right {
						float: right;
				}

				.f-left {
						float: left;
				}

				p {
						margin: 0 !important;
						padding: 0 !important;
				}
		</style>

</head>

<body>
		@php $setting = $examSet->setting; @endphp
		@if ($setting && $setting->is_display_top)
				<table class="table-bordered table">
						<thead>
								<tr>
										<td class="f-left text-center	" style="width:350px">
												@php
														$top_left = preg_replace('{code}', '<div class="box-center box"> Mã đề thi <br>' . '001' . '</div>', $setting->top_left, 1);
												@endphp
												{!! $top_left !!}
										</td>
										<td class="f-right text-center" style="width:350px">
												@php
														$top_right = preg_replace('{subject}', $examSet->subject->name, $setting->top_right, 1);
												@endphp
												{!! $top_right !!}
										</td>
								</tr>
						</thead>
				</table>
				{{-- <div class="row" style="font-size:16px">
						<div class="col-6 f-left text-center">
								@php
										$top_left = preg_replace('{code}', '<div class="box-center box"> Mã đề thi <br>' . '001' . '</div>', $setting->top_left, 1);
								@endphp
								{!! $top_left !!}
						</div>
						<div class="col-6 f-right text-center">
								@php
										$top_right = preg_replace('{subject}', $examSet->subject->name, $setting->top_right, 1);
								@endphp
								{!! $top_right !!}
						</div>
				</div> --}}
		@endif

		@if ($setting && $setting->is_display_center)
				<div class="row text-center" style="margin: 20px 0">
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
				<div class="row" style="padding-bottom: 0">
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
				<div class="row" style="padding: 0 15px; margin-bottom: 10px">
						<table class="table-bordered table">
								<thead>
										@if ($question->length_answer < 50)
												<tr>
														@foreach ($question->answers as $idx2 => $answer)
																<td style="width:150px">
																		<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
																		@php
																				$ans = preg_replace('<p>', 'span', $answer['content'], 1);
																				$ans = preg_replace('</p>', '/span', $ans, 1);
																		@endphp
																		<span>{!! $ans !!}</span>
																</td>
														@endforeach
												</tr>
										@elseif ($question->length_answer < 100)
												@for ($i = 0; $i < 4; $i += 2)
														<tr>
																@for ($j = 0; $j < 2; $j++)
																		<td style="width:300px">
																				<span class="text-bold">{{ config('fixeddata.answer_index')[$i + $j + 1] }}.</span>
																				@php
																						$ans = preg_replace('<p>', 'span', $question->answers[$i + $j]['content'], 1);
																						$ans = preg_replace('</p>', '/span', $ans, 1);
																				@endphp
																				<span>{!! $ans !!}</span>
																		</td>
																@endfor
														</tr>
												@endfor
										@else
												@foreach ($question->answers as $idx2 => $answer)
														<tr>
																<td>
																		<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
																		@php
																				$ans = preg_replace('<p>', 'span', $answer['content'], 1);
																				$ans = preg_replace('</p>', '/span', $ans, 1);
																		@endphp
																		<span>{!! $ans !!}</span>
																</td>
														</tr>
												@endforeach
										@endif
								</thead>
						</table>
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
