@extends('layouts.admin')

@section('title', 'Duyệt câu hỏi vào ngân hàng')

@section('content')
		<div class="modal" id="show-question" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="block-rounded block-transparent mb-0 block">
										<div class="block-header block-header-default">
												<h3 class="block-title">Duyệt câu hỏi vào ngân hàng đề</h3>
												<div class="block-options">
														<button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
																<i class="fa fa-fw fa-times"></i>
														</button>
												</div>
										</div>
										<div class="block-content fs-sm">
												<div id='question-table'>
												</div>
										</div>
								</div>
						</div>
				</div>
		</div>

		<div class="content">
				<div class="block-rounded block">
						<div class="block-header block-header-default">
								<h3 class="block-title"> </h3>
								<div class="block-options">

								</div>
						</div>
						<div class="block-content block-content-full">
								<div class="table-responsive">
										<table class="table-striped table-vcenter js-dataTable-full table" id="exam-table">
												<thead>
														<tr style="">
																<th style="width: 6%;" class="text-center">STT</th>
																<th style="width: 54%" class="text-truncate">Câu hỏi</th>
																<th style="width: 12%;" class="text-center">Tạo bởi</th>
																<th style="width: 12%;" class="text-center">Thời gian tạo</th>
																<th style="width: 12%;" class="text-center">Thao tác</th>
														</tr>
												</thead>
												<tbody>
														@foreach ($questions as $question)
																<tr>
																		<td class="text-center">{{ $loop->iteration }}</td>
																		<td style="max-width: 450px" class="text-truncate">{!! $question->content !!}</td>
																		<td class="text-center">{{ $question->teacher->fullname }}</td>
																		<td class="text-center">{{ $question->created_at }}</td>
																		<td class="text-center">
																				<div class="btn-group">
																						<button class="btn btn-sm btn-alt-secondary show-btn" data-bs-toggle="tooltip" title="Xem thông tin" data-id="{{ $question->id }}">
																								<i class="fa fa-fw fa-eye"></i>
																						</button>
																				</div>
																		</td>
																</tr>
														@endforeach
												</tbody>
										</table>
								</div>
						</div>
				</div>
		</div>
@endsection


@section('js_after')
		<script>
		  const questions = @json($questions);
		  const rejectStatus = @json(QUESTION_STATUS_REJECTED);
      const acceptStatus = @json(QUESTION_STATUS_APPROVED);

		  $('.show-btn').on('click', function(e) {
		    const questionId = $(this).data('id');
		    const question = questions.find(question => question.id == questionId);
		    fetch('{{ route('admin.question.template', ['question' => ':id']) }}'.replace(':id', questionId))
		      .then(res => res.json())
		      .then(data => {
		        $('#question-table').html(data.html);
		        $('#show-question').modal('show');
		      });
		  });

		  function approvedQuestion(id, ignore = false) {
		    let url = '{{ route('admin.question-bank.approved', ['question' => ':id']) }}'.replace(':id', id)
		    url = `${url}?status=${acceptStatus}&ignore=${ignore ? 1 : 0}`
		    fetch(url)
		      .then(res => res.json())
		      .then(data => {
            if (data.success) {
              showNotify("success", data.message)
              $('#show-question').modal('hide');
            } else {
              $('#duplicate-question').replaceWith(data.data)
            }
		      });
		  }

		  function rejectQuestion(id) {
		    let url = '{{ route('admin.question-bank.approved', ['question' => ':id']) }}'.replace(':id', id)
		    url = `${url}?status=${rejectStatus}`
		    fetch(url)
		      .then(res => res.json())
		      .then(data => {
		        showNotify("success", data.message)
		        $('#show-question').modal('hide');
		      });
		  }
		</script>
@endsection
