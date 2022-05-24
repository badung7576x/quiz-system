@extends('layouts.admin')

@section('title', __('Trang quản trị'))

@section('content')
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Danh sách đề thi</h3>
        <div class="block-options">
          <a href="#" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          @for($i = 0; $i < 10; $i++)
            
          
          <div class="col-sm-6 col-md-3">
            <div class="block block-rounded bg-info-light">
              <div class="block-content block-content-full text-center bg-city">
                <div class="item item-2x item-circle bg-white-10 py-3 my-3 mx-auto">
                  <i class="fab fa-html5 fa-2x text-white-75"></i>
                </div>
                <div class="fs-sm text-white-75">
                  10 lessons • 3 hours
                </div>
              </div>
              <div class="block-content block-content-full">
                <h4 class="h5 mb-1">
                  Learn HTML5 in 10 simple and easy to follow steps
                </h4>
                <div class="fs-sm text-muted">November 5, 2021</div>
                <hr>
                <div class="text-center mt-2">
                  <div class="btn-group">
                    <a href="#" class="btn btn-sm btn-alt-secondary" title="{{ __('Xem') }}">
                      <i class="fa fa-fw fa-eye"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-alt-secondary" title="{{ __('Tải xuống') }}">
                      <i class="fa fa-fw fa-download"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endfor
        </div>
      </div>
      <div class="block block-rounded">
        <div class="row">
          <div class="col-12">
            <div class="dataTables_paginate">
              <ul class="pagination">
                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0"
                    class="page-link"><i class="fa fa-angle-left"></i></a></li>
                <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                <li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="5" tabindex="0"
                    class="page-link"><i class="fa fa-angle-right"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
