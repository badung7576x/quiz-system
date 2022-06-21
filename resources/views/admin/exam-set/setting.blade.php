@extends('layouts.admin')

@section('title', 'Soạn thảo câu hỏi')

@section('content')
  <form action="{{ route('admin.exam-set.setting.save', ['exam_set' => $examSet->id]) }}" method="POST">
    @csrf
    <div class="content content-boxed">
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Cài đặt mẫu đề thi</h3>
          <div class="block-options">
            <a href="{{ route('admin.exam-set.show', ['exam_set' => $examSet->id]) }}" class="btn btn-sm btn-dark">
              <i class="fa fa-arrow-left"></i> Quay lại
            </a> 
            <button type="submit" class="btn btn-sm btn-outline-success" onclick="createExamSet()">
              <i class="fa fa-save"></i> Lưu
            </button> 
          </div>
        </div>
        <div class="block-content block-content-full">
          @php $setting = $examSet->setting; @endphp
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-8">
                  <div class="row mb-3">
                    <label class="col-sm-12 col-form-label h4">Hiển thị phần ① và ②</label>
                    <div class="col-sm-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" name="is_display_top" @checked(old('is_display_top', $setting->is_display_top ?? '') == 1)>
                        <label class="form-check-label">Có</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="0" name="is_display_top" @checked(old('is_display_top', $setting->is_display_top ?? 0) == 0)>
                        <label class="form-check-label">Không</label>
                      </div>
                    </div>
                    <label class="col-sm-12 col-form-label h4">Nội dung phần ①</label>
                    <div class="col-sm-12">
                      <textarea class="ckeditor1 form-control @error('top_left') is-invalid @enderror" name="top_left">{!! old('top_left', $setting->top_left ?? '') !!}</textarea>
                      @error('top_left')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <label class="col-sm-12 col-form-label h4">Nội dung phần ②</label>
                    <div class="col-sm-12">
                      <textarea class="ckeditor1 form-control @error('top_right') is-invalid @enderror" name="top_right">{!! old('top_right', $setting->top_right ?? '') !!}</textarea>
                      @error('top_right')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <hr class="mt-4">
                    <label class="col-sm-12 col-form-label h4">Hiển thị phần ③</label>
                    <div class="col-sm-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" name="is_display_center" @checked(old('is_display_center', $setting->is_display_center ?? '') == 1)>
                        <label class="form-check-label">Có</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="0" name="is_display_center" @checked(old('is_display_center', $setting->is_display_center ?? 0) == 0)>
                        <label class="form-check-label">Không</label>
                      </div>
                    </div>
                    <label class="col-sm-12 col-form-label h4">Nội dung phần ③</label>
                    <div class="col-sm-12">
                      <textarea class="ckeditor1 form-control @error('center') is-invalid @enderror" name="center">{!! old('center', $setting->center ?? '') !!}</textarea>
                      @error('center')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <hr class="mt-4">
                    <label class="col-sm-12 col-form-label h4">Hiển thị phần ⑤</label>
                    <div class="col-sm-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" name="is_display_bottom" @checked(old('is_display_bottom', $setting->is_display_bottom ?? '') == 1)>
                        <label class="form-check-label">Có</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="0" name="is_display_bottom" @checked(old('is_display_bottom', $setting->is_display_bottom ?? 0) == 0)>
                        <label class="form-check-label">Không</label>
                      </div>
                    </div>
                    <label class="col-sm-12 col-form-label h4">Nội dung phần ⑤</label>
                    <div class="col-sm-12">
                      <textarea class="ckeditor1 form-control @error('bottom') is-invalid @enderror" name="bottom">{!! old('bottom', $setting->bottom ?? '') !!}</textarea>
                      @error('bottom')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="row">
                    <a class="img-link img-link-zoom-in img-lightbox" target="_blank" href="{{ asset('images/template_exam_file.png') }}">
                      <img class="img-fluid" src="{{ asset('images/template_exam_file.png') }}" alt="">
                    </a>
                    <div class="text-center mt-4"><i>Hình ảnh mẫu đề thi</i></div>
                    <div class="text-center"><i>(Chọn vào ảnh để xem rõ hơn)</i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('css_before')
  <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css')}}">
@endsection

@section('js_after')
  <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      initCkeditor();
      $('.image-link').magnificPopup({type:'image'});
    });

    function initCkeditor() {
      $(".ckeditor1").each(function(_, ckeditor) {
        CKEDITOR.replace(ckeditor, {
          toolbar: [{
              name: 'clipboard',
              items: ['Undo', 'Redo']
            },
            {
              name: 'basicstyles',
              items: ['Bold', 'Italic', 'Underline', 'Strike', 'CopyFormatting', 'RemoveFormat']
            },
            {
              name: 'paragraph',
              items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            {
              name: 'insert',
              items: ['Table']
            },
            {
              name: 'colors',
              items: ['TextColor', 'BGColor']
            },
            {
              name: 'tools',
              items: ['Maximize']
            },
          ],
          extraPlugins: 'mathjax',
          mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
          removeButtons: 'PasteFromWord'
        })
      });
    }
  </script>
@endsection
