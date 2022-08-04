<!DOCTYPE html>
<html lang="en">

<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Đề thi</title>
		<style>
				@page {
						margin: 100px 25px;
				}

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
						margin-bottom: 50px;
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

				header {
						position: fixed;
						top: -60px;
						left: 0px;
						right: 0px;
						height: 50px;
				}

				footer {
						position: fixed;
						bottom: -60px;
						left: 0px;
						right: 0px;
						height: 50px;
				}
		</style>

</head>

<body>
		<header>
				Our Code World
		</header>

		<footer>
				Copyright &copy; <?php echo date('Y'); ?>
		</footer>
		<main>
				@php $setting = $examSet->setting; @endphp
				@if ($setting && $setting->is_display_top)
						<table class="table-bordered table">
								<thead>
										<tr>
												<td class="f-left text-center" style="width:350px">
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

				<div class="row text-center" style="margin: 5px 0;">
						<div class="col-12">
								<div class="text-bold text-underline">
										ĐỀ THI
								</div>
						</div>
				</div>
				@php $questions = $examSet->questions @endphp
				@foreach ($questions as $idx => $question)
						<div class="row" style="padding-bottom: 0; margin-left: 30px">
								<div class="col-12">
										<div>
												<span class="text-bold">Câu {{ $loop->iteration }}:</span>
												@php
														$cont = preg_replace('<p>', 'span', $question->content, 1);
														$cont = preg_replace('</p>', '/span', $cont, 1);
												@endphp
												<span>{!! $cont !!}</span>
										</div>
								</div>
						</div>
						<div class="row" style="padding: 0 45px; margin-bottom: 10px">
								<table>
										<thead>
												@switch($question->type)
														@case(QUESTION_MULTI_CHOICE)
																@if ($question->length_answer < 50)
																		<tr>
																				@foreach ($question->answers as $idx2 => $answer)
																						<td style="width:150px">
																								<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
																								<span>{!! $answer['content_1'] !!}</span>
																						</td>
																				@endforeach
																		</tr>
																@elseif ($question->length_answer < 100)
																		@for ($i = 0; $i < 4; $i += 2)
																				<tr>
																						@for ($j = 0; $j < 2; $j++)
																								<td style="width:300px">
																										<span class="text-bold">{{ config('fixeddata.answer_index')[$i + $j + 1] }}.</span>
																										<span>{!! $answer['content_1'] !!}</span>
																								</td>
																						@endfor
																				</tr>
																		@endfor
																@else
																		@foreach ($question->answers as $idx2 => $answer)
																				<tr>
																						<td>
																								<span class="text-bold">{{ config('fixeddata.answer_index')[$idx2 + 1] }}.</span>
																								<span>{!! $answer['content_1'] !!}</span>
																						</td>
																				</tr>
																		@endforeach
																@endif
														@break

														@case(QUESTION_TRUE_FALSE)
																@foreach ($question->answers as $idx2 => $answer)
																		<tr style="margin-bottom: 10px">
																				<td style="width:550px;">
																						<span>{{ $idx2 + 1 }}.</span>
																						<span>{!! $answer['content_1'] !!}</span>
																				</td>
																				<td style="width:100px; padding-left: 25px">
																						<span>....</span>
																				</td>
																		</tr>
																@endforeach
														@break

														@default
												@endswitch


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
		</main>
</body>

</html>
