@extends('layouts.admin')

@section('title', 'Môn học')

@section('content')
  <div class="content content-boxed">
    <div class="block-rounded block">
      <div class="block-header block-header-default">
        <h3 class="block-title">Cập nhật nội dung</h3>
        <div class="block-options">
          @php
            $previousUrl = explode('?', url()->previous())[0];
            if ($previousUrl == route('admin.dashboard.index')) {
                session()->put('backUrl', url()->previous());
                $backUrl = url()->previous();
            } if ($previousUrl == route('admin.subject.index')) {
                session()->put('backUrl', url()->previous());
                $backUrl = url()->previous();
            } else {
                $backUrl = session()->get('backUrl');
            }
          @endphp
          <a href="{{ $backUrl }}" class="btn btn-sm btn-secondary">
              <i class="fa fa-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn btn-sm btn-outline-success" onclick="createSubject()">
              <i class="fa fa-save"></i> Lưu lại
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-lg-12 space-y-5">
            <!-- Form Horizontal - Default Style -->
            <form id="create_subject" class="" action="{{ route('admin.subject.update', ['subject' => $subject->id]) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <label class="col-12 col-form-label">Tên môn học <span style="color: red">*</span></label>
                        <div class="col-12">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $subject->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                  <div class="row mb-2">
                    <label class="col-12 col-form-label">Mô tả</label>
                    <div class="col-12">
                      <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ old('description', $subject->description) }}</textarea>
                      @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mb-3">
                    <label class="col-12 col-form-label">Các nội dung môn học</label>
                    <div class="col-12" id="content-area">
                      <div class="row mb-2">
                        <label class="col-2 col-form-label">Nội dung 1 <span style="color: red">*</span></label>
                        <div class="col-9">
                          @php $content = $subject->contents->first(); @endphp
                          <input type="text" class="form-control @error('subject_contents.' . $content->id) is-invalid @enderror" name="subject_contents[{{ $content->id }}]" value="{{ old('subject_contents.' . $content->id, $content->name) }}">
                          @error('subject_contents.' . $content->id)
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-1 d-flex justify-content-end mt-2">
                            <a href="#" onclick="addNewContent()">
                              <i class="fa fa-plus-circle text-success"></i>
                            </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css_before')
@endsection

@section('js_after')
<script>
  function addContent(data) {
    const contentArea = document.getElementById('content-area');
    const index = contentArea.childElementCount;
    var newDiv = `
      <div class="row mb-2">
        <label class="col-2 col-form-label">Nội dung ${index + 1} <span style="color: red">*</span></label>
        <div class="col-9">
          <input type="text" class="form-control ${data.error ? 'is-invalid': ''}" name="subject_contents[${data.id}]" value="${data.name || ''}">
          ${data.error ? `<div class="invalid-feedback">${data.error}</div>` : ''}
        </div>
        <div class="col-1 d-flex justify-content-end mt-2">
          <a href="#" onclick="removeContent(this)">
            <i class="fa fa-minus-circle text-danger"></i>
          </a>
        </div>
      </div>
    `;
    $(contentArea).append(newDiv);
  }

  function addNewContent(data) {
    const contentArea = document.getElementById('content-area');
    const index = contentArea.childElementCount;

    var newDiv = `
      <div class="row mb-2">
        <label class="col-2 col-form-label">Nội dung ${index + 1} <span style="color: red">*</span></label>
        <div class="col-9">
          <input type="text" class="form-control ${data && data.error ? 'is-invalid': ''}" name="new_subject_contents[]" value="${data?.name || ''}">
          ${ data && data.error ? `<div class="invalid-feedback">${data.error}</div>` : ''}
        </div>
        <div class="col-1 d-flex justify-content-end mt-2">
          <a href="#" onclick="removeContent(this)">
            <i class="fa fa-minus-circle text-danger"></i>
          </a>
        </div>
      </div>
    `;
    $(contentArea).append(newDiv);
  }

  function removeContent(e) {
    $(e).closest('.row').remove();
  }

  function createSubject() {
    $('#create_subject').submit();
  }

  function showOldContent() {
    const contentArea = document.getElementById('content-area');
    let oldContent = @json(old('subject_contents', $subject->contents));
    let newContent = @json(old('new_subject_contents', []));
    const newErrorContent = @json($errors->get('new_subject_contents.*'));

    if (!Array.isArray(oldContent)) {
      const oldErrorContent = @json($errors->get('subject_contents.*'));

      oldContent = Object.keys(oldContent).map(function(key) {
        return {
          id: key,
          name: oldContent[key],
          error: oldErrorContent['subject_contents.' + key]
        };
      });

      newContent = newContent.map(function(key, index) {
        return {
          id: index,
          name: key,
          error: newErrorContent['new_subject_contents.' + index] ? newErrorContent['new_subject_contents.' + index][0] : ''
        };
      });
    } 
    oldContent && oldContent.forEach(function(content, index) {
      if (index != 0) addContent(content);
    });

    console.log(newContent)

    newContent && newContent.forEach(function(content, index) {
      addNewContent(content);
    });

  }

  $(document).ready(function() {
    showOldContent();
  });

</script>
@endsection
