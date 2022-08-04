@extends('layouts.admin')

@section('title', 'Duyệt đề thi')

@section('content')
		<div class="modal" id="show-ex" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
							<div class="block-rounded block-transparent mb-0 block">
									<div class="block-header block-header-default">
											<h3 class="block-title">Xem đề thi</h3>
											<div class="block-options">
													<button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
															<i class="fa fa-fw fa-times"></i>
													</button>
											</div>
									</div>
									<div class="block-content fs-sm">
										<iframe name="exam-iframe" id="view-exam-set"
											src="" 
											frameborder="0" style="width: 100%; height: 80vh;"></iframe>
									</div>
							</div>
					</div>
			</div>
		</div>
		<div class="content">
				<div class="block-rounded block">
						<div class="block-header block-header-default">
								<h3 class="block-title"> Danh sách đề thi chờ duyệt</h3>
								<div class="block-options">

								</div>
						</div>
						<div class="block-content block-content-full">
								<div class="table-responsive">
										<table class="table-striped table-vcenter js-dataTable-full table" id="exam-table">
												<thead>
														<tr style="">
																<th style="width: 6%;" class="text-center">STT</th>
																<th style="width: 54%" class="text-truncate">Đề thi</th>
																<th style="width: 12%;" class="text-center">Tạo bởi</th>
																<th style="width: 12%;" class="text-center">Thời gian tạo</th>
																<th style="width: 12%;" class="text-center">Thao tác</th>
														</tr>
												</thead>
												<tbody>
														@foreach ($examSets as $examSet)
																<tr>
																		<td class="text-center">{{ $loop->iteration }}</td>
																		<td style="max-width: 450px" class="text-truncate">{!! $examSet->name !!}</td>
																		<td class="text-center">{{ $examSet->create_by->fullname }}</td>
																		<td class="text-center">{{ $examSet->created_at }}</td>
																		<td class="text-center">
																				<div class="btn-group">
																						<button class="btn btn-sm btn-alt-secondary show-btn" data-bs-toggle="tooltip" title="Xem thông tin" data-id="{{ $examSet->id }}">
																								<i class="fa fa-fw fa-eye"></i>
																						</button>
																						<button class="btn btn-sm btn-alt-success accept-btn" data-bs-toggle="tooltip" title="Đồng ý" 
																							onclick="showConfirmModal({{ $examSet->id }}, {{ EXAM_SET_STATUS_APPROVED }})">
																							<i class="fa fa-fw fa-check"></i>
																						</button>
																						<button class="btn btn-sm btn-alt-danger reject-btn" data-bs-toggle="tooltip" title="Từ chối" 
																							onclick="showConfirmModal({{ $examSet->id }}, {{ EXAM_SET_STATUS_REJECT }})">
																							<i class="fa fa-fw fa-ban"></i>
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
			const examSets = @json($examSets);

			$('.show-btn').on('click', function(e) {
		    const esID = $(this).data('id');
		    const examSet = examSets.find(ex => ex.id == esID);

				let url = "{{ route('admin.exam-set.pdf', ['exam_set' => ':exID', 'exam_set_detail' => ':exdID']) }}"
				url = url.replace(':exID', esID)
				url = url.replace(':exdID', examSet.exam_set_details[0].id)
		    $('#view-exam-set').attr('src', url)
				$('#show-ex').modal('show');
		  });

			function showConfirmModal(id, status = 0) {
				let message = "Bạn từ chối duyệt đề thi này ?"
				let url = "{{ route('admin.exam-set.approved', ['exam_set' => ':exID']) }}"
				url = url.replace(':exID', id)
				if(status == 2) {
					message = "Bạn đồng ý duyệt đề thi này ?"
					url += '?status={{ EXAM_SET_STATUS_APPROVED }}'
				} else {
					
					url += '?status={{ EXAM_SET_STATUS_REJECT }}'
				}
				toast.fire({
					title: 'Xác nhận',
					text: message,
					icon: 'warning',
					showCancelButton: true,
					customClass: {
						confirmButton: 'btn btn-success m-1',
						cancelButton: 'btn btn-secondary m-1'
					},
					confirmButtonText: '{{ __('Xác nhận') }}',
					cancelButtonText: '{{ __('Hủy') }}',
					html: false,
					preConfirm: e => {
						return new Promise(resolve => {
							setTimeout(() => {
								resolve();
							}, 50);
						});
					}
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href  = url;
					}
				})
			}
		</script>
@endsection
