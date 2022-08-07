<div class="col-lg-12 space-y-5">
  <div class="row">
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Nội dung chính <span style="color: red">*</span></label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('content') is-invalid @enderror" name="content" rows="5">{!! old('content', $question->content) !!}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-8 col-form-label mb-2">Danh sách các câu hỏi đúng/sai</label>
        <div class="col-4 d-flex justify-content-end mt-2">
          <a class="me-3" href="#" onclick="addNewContent()">
            <i class="fa fa-plus-circle text-success"></i> Thêm câu hỏi
          </a>
          <a class="removeBtn" href="#" onclick="removeContent()">
            <i class="fa fa-minus-circle text-danger"></i> Xóa câu hỏi
          </a>
        </div>
        <div class="col-12" id="content-area">
          @php $answer = $question->answers->first() @endphp
          <div class="row mb-4">
            <div class="col-1">
              1
            </div>
            <div class="col-11">
              <textarea class="form-control @error('answers.' . $answer->id ) is-invalid @enderror" name="answers[{{ $answer->id }}]">{{ old('answers.' . $answer->id, $answer->content_1) }}</textarea>
              @error('answers.' . $answer->id)
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-12 mt-2 d-flex justify-content-end">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="1" name="correct_answer[{{ $answer->id }}]" @checked(old('correct_answer.' . $answer->id, $answer->is_correct) == 1)>
                <label class="form-check-label">Đúng</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="0" name="correct_answer[{{ $answer->id }}]" @checked(old('correct_answer.' . $answer->id, $answer->is_correct) == 0)>
                <label class="form-check-label">Sai</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function addContent(data) {
    const contentArea = document.getElementById('content-area');
    const index = $("#content-area > .row").length;
    var newDiv = `
      <div class="row mb-4">
        <div class="col-1">
          ${ index + 1}
        </div>
        <div class="col-11">
          <textarea class="form-control  ${data.error ? 'is-invalid': ''}" name="answers[${data.id}]">${data.content_1 || ''}</textarea>
          ${data.error ? `<div class="invalid-feedback">${data.error}</div>` : ''}
        </div>
        <div class="col-sm-12 mt-2 d-flex justify-content-end">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="1" name="correct_answer[${data.id}]" ${data.is_correct == 1 ? 'checked': ''}>
            <label class="form-check-label">Đúng</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="0" name="correct_answer[${data.id}]" ${data.is_correct == 0 ? 'checked': ''}>
            <label class="form-check-label">Sai</label>
          </div>
        </div>
      </div>
    `;
    $(contentArea).append(newDiv);
  }

  function addNewContent(data) {
    const contentArea = document.getElementById('content-area');
    const index = $("#content-area > .row").length;
    const isCorrect = data && data.is_correct ? data.is_correct : 0;
    var newDiv = `
      <div class="row mb-4">
        <div class="col-1">
          ${ index + 1}
        </div>
        <div class="col-11">
          <textarea class="form-control  ${data && data.error ? 'is-invalid': ''}" name="new_answers[]">${data && data.content_1 || ''}</textarea>
          ${data && data.error ? `<div class="invalid-feedback">${data.error}</div>` : ''}
        </div>
        <div class="col-sm-12 mt-2 d-flex justify-content-end">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="1" name="new_correct_answer[${index + 9999}]" ${isCorrect == 1 ? 'checked': ''}>
            <label class="form-check-label">Đúng</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="0" name="new_correct_answer[${index + 9999}]" ${isCorrect == 0 ? 'checked': ''}>
            <label class="form-check-label">Sai</label>
          </div>
        </div>
      </div>
    `;
    $(contentArea).append(newDiv);
  }

  function removeContent(e) {
    if ($("#content-area > .row").length <= 1) return;
    $("#content-area > .row").last().remove('');
}
</script>
