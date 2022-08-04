<div class="col-lg-12 space-y-5">
  <div class="row">
    <div class="col-12">
      <div class="row mb-3">
        @error('correct_answer')
          <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <label class="col-sm-12 col-form-label">Nội dung chính <span style="color: red">*</span></label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('content') is-invalid @enderror" name="content" rows="5">{!! old('content', '') !!}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-8 col-form-label mb-2">Danh sách các câu hỏi</label>
        <div class="col-4 d-flex justify-content-end mt-2">
          <a class="me-3" href="#" onclick="addContent()">
            <i class="fa fa-plus-circle text-success"></i> Thêm câu hỏi
          </a>
          <a class="removeBtn" href="#" onclick="removeContent()">
            <i class="fa fa-minus-circle text-danger"></i> Xóa câu hỏi
          </a>
        </div>
        <div class="col-12" id="content-area">
          <div class="row mb-4">
            <div class="col-1 d-flex justify-content-end mt-2">
              1
            </div>
            <div class="col-5">
              <textarea class="form-control @error('subject_contents.0') is-invalid @enderror" name="subject_contents[]"></textarea>
              @error('subject_contents.0')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-1 d-flex justify-content-end mt-2">
              A
            </div>
            <div class="col-5">
              <textarea class="form-control @error('subject_contents.0') is-invalid @enderror" name="subject_contents[]"></textarea>
              @error('subject_contents.0')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function addContent(content, error = null) {
    const contentArea = $('#content-area');
    const index = $("#content-area > .row").length;
    var newDiv = `
      <div class="row mb-4">
        <div class="col-1 d-flex justify-content-end mt-2">
          ${index + 1}
        </div>
        <div class="col-5">
          <textarea class="form-control @error('subject_contents.0') is-invalid @enderror" name="subject_contents[]"></textarea>
          @error('subject_contents.0')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-1 d-flex justify-content-end mt-2">
          ${String.fromCharCode(97 + index).toUpperCase()}
        </div>
        <div class="col-5">
          <textarea class="form-control @error('subject_contents.0') is-invalid @enderror" name="subject_contents[]"></textarea>
          @error('subject_contents.0')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    `;
    $(contentArea).append(newDiv);
  }

  function removeContent() {
    if ($("#content-area > .row").length <= 1) return;
    $("#content-area > .row").last().remove('');
}
</script>
