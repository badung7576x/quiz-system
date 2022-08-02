@extends('layouts.admin')

@section('title', __('Trang quản trị'))

@section('content')
		<div class="modal" id="show-subject" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="block-rounded block-transparent mb-0 block">
										<div class="block-header block-header-default">
												<h3 class="block-title">Thông tin môn học</h3>
												<div class="block-options">
														<button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
																<i class="fa fa-fw fa-times"></i>
														</button>
												</div>
										</div>
										<div class="block-content fs-sm">
												<table class="table-borderless table-striped table-vcenter fs-sm table" id='subject-table'>
												</table>
										</div>
								</div>
						</div>
				</div>
		</div>

		<div class="content">
				<div class="row">
						<div class="col-sm-6 col-xxl-3">
								<div class="block-rounded d-flex flex-column block">
										<div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
												<dl class="mb-0">
														<dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Bộ môn</dd>
														<dt class="fs-3 fw-bold">Tiếng Anh</dt>
												</dl>
												<div class="item item-rounded-lg bg-body-light">
														<i class="fa fa-book-reader fs-3 text-primary"></i>
												</div>
										</div>
										<div class="bg-body-light rounded-bottom">
												<div class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between">
														<a href="javascript:void(0)" id="show-btn">Xem nội dung</a>
														<a href="{{ route('admin.subject.edit', ['subject' => $subject->id]) }}"><i class="fa fa-edit ms-1 fs-base"></i></a>
												</div>
										</div>
								</div>
						</div>
						<div class="col-sm-6 col-xxl-3">
								<div class="block-rounded d-flex flex-column block">
										<div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
												<dl class="mb-0">
														<dt class="fs-3 fw-bold">{{ $summary['total'] }}</dt>
														<dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Câu hỏi đã duyệt</dd>
												</dl>
												<div class="item item-rounded-lg bg-body-light">
														<i class="fa fa-question fs-3 text-primary"></i>
												</div>
										</div>
										<div class="bg-body-light rounded-bottom">
												<a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
														href="{{ route('admin.question-bank.index') }}">
														<span>Xem ngân hàng đề</span>
														{{-- <i class="fa fa-arrow-alt-circle-right ms-1 fs-base opacity-25"></i> --}}
												</a>
										</div>
								</div>
						</div>
						<div class="col-sm-6 col-xxl-3">
								<div class="block-rounded d-flex flex-column block">
										<div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
												<dl class="mb-0">
														<dt class="fs-3 fw-bold">{{ $summary['waitting'] }}</dt>
														<dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Câu hỏi chờ duyệt</dd>
												</dl>
												<div class="item item-rounded-lg bg-body-light">
														<i class="fa fa-eye fs-3 text-primary"></i>
												</div>
										</div>
										<div class="bg-body-light rounded-bottom">
												<a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
														href="{{ route('admin.question-bank.wait-accept') }}">
														<span>Xem danh sách câu hỏi</span>
														{{-- <i class="fa fa-arrow-alt-circle-right ms-1 fs-base opacity-25"></i> --}}
												</a>
										</div>
								</div>
						</div>
						<div class="col-sm-6 col-xxl-3">
								<div class="block-rounded d-flex flex-column block">
										<div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
												<dl class="mb-0">
														<dt class="fs-3 fw-bold">{{ $summary['teacher'] }}</dt>
														<dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Giáo viên</dd>
												</dl>
												<div class="item item-rounded-lg bg-body-light">
														<i class="far fa-user fs-3 text-primary"></i>
												</div>
										</div>
										<div class="bg-body-light rounded-bottom">
												<a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="{{ route('admin.teacher.index') }}">
														<span>Xem danh sách giáo viên</span>
														{{-- <i class="fa fa-arrow-alt-circle-right ms-1 fs-base opacity-25"></i> --}}
												</a>
										</div>
								</div>
						</div>
						<div class="col-xl-6">
								<!-- Radar Chart -->
								<div class="block-rounded block">
										<div class="block-header block-header-default">
												<h3 class="block-title">Phân bố câu hỏi theo nội dung</h3>
												<div class="block-options">
														<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
																<i class="si si-refresh"></i>
														</button>
												</div>
										</div>
										<div class="block-content block-content-full text-center">
												<div class="px-xxl-7 py-3">
														<!-- Radar Chart Container -->
														<canvas id="js-chartjs-radar2"></canvas>
												</div>
										</div>
								</div>
								<!-- END Radar Chart -->


								<!-- Radar Chart -->
								<div class="block-rounded block">
										<div class="block-header block-header-default">
												<h3 class="block-title">Phân bố câu hỏi theo dạng câu hỏi</h3>
												<div class="block-options">
														<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
																<i class="si si-refresh"></i>
														</button>
												</div>
										</div>
										<div class="block-content block-content-full text-center">
												<div class="px-xxl-7 py-3">
														<!-- Radar Chart Container -->
														<canvas id="js-chartjs-radar"></canvas>
												</div>
										</div>
								</div>
								<!-- END Radar Chart -->
						</div>

						<div class="col-xl-6">
								<!-- Bars Chart -->
								<div class="block-rounded block">
										<div class="block-header block-header-default">
												<h3 class="block-title">Thống kê giáo viên</h3>
												<div class="block-options">

												</div>
										</div>
										<div class="block-content block-content-full text-center">
												<div class="py-3">
														<canvas id="js-chartjs-bars"></canvas>
												</div>
										</div>
								</div>
								<!-- END Bars Chart -->
						</div>
				</div>
		</div>
@endsection
@section('js_after')
		<script src="{{ asset('js/plugins/chart.js/Chart.min.js') }}"></script>

		<script>
		  const teacherData = @json($teacherAnalysis);
		  const questionBankData = @json($questionBankAnalysis);

		  function initBars(input) {
		    const data = {
		      labels: [
		        'Giáo viên',
		        'Giáo viên bộ môn',
		        'Giáo viên chuyên môn',
		        'Trưởng nhóm chuyên môn',
		      ],
		      datasets: [{
		        label: 'Số lượng giáo viên',
		        backgroundColor: '#65A30D',
		        borderColor: '#d9e8c3',
		        data: input['data'],
		      }]
		    };

		    const config = {
		      type: 'bar',
		      data: data,
		      options: {
		        scales: {
		          y: {
		            beginAtZero: true
		          }
		        }
		      },
		    };

		    const myChart = new Chart(
		      document.getElementById('js-chartjs-bars'),
		      config
		    );
		  }

		  function initRadars(input) {
		    const data = {
		      labels: input['name'],
		      datasets: [{
		        label: 'Số lượng câu hỏi',
		        data: input['data'],
		        fill: true,
		        backgroundColor: 'rgba(255, 99, 132, 0.2)',
		        borderColor: 'rgb(255, 99, 132)',
		        pointBackgroundColor: 'rgb(255, 99, 132)',
		        pointBorderColor: '#fff',
		        pointHoverBackgroundColor: '#fff',
		        pointHoverBorderColor: 'rgb(255, 99, 132)'
		      }]
		    };

		    const config = {
		      type: 'radar',
		      data: data,
		      options: {
		        elements: {
		          line: {
		            borderWidth: 3
		          }
		        }
		      },
		    };

		    const myChart2 = new Chart(
		      document.getElementById('js-chartjs-radar'),
		      config
		    );
		    const myChart3 = new Chart(
		      document.getElementById('js-chartjs-radar2'),
		      config
		    );
		  }

		  initBars(teacherData)
		  initRadars(questionBankData)

		  $('#show-btn').on('click', function(e) {
		    const subject = @json($subject);
		    const html = `
					<tbody>
						<tr>
							<td class="fw-semibold" style="width: 30%">Môn học</td>
							<td>${subject.name}</td>
						</tr>
						<tr>
							<td class="fw-semibold" style="width: 30%">Mô tả</td>
							<td>${subject.description ?? ''}</td>
						</tr>
						<tr>
							<td class="fw-semibold align-top" style="width: 30%">Nội dung</td>
							<td>
								${
									subject.contents.map(content => `${content.order}. ${content.name}`).join('<br>')
								}
							</td>
						</tr>
					</tbody>`;
		    $('#subject-table').html(html);
		    $('#show-subject').modal('show');
		  });
		</script>
@endsection
