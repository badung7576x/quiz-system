<div class="col-lg-12 space-y-5">
  <div class="row">
    <div class="col-12">
      <div class="row mb-3">
        @error('correct_answer')
          <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <label class="col-sm-12 col-form-label">Nội dung câu hỏi</label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('content') is-invalid @enderror" name="content">{!! old('content', $question->content) !!}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-6 col-form-label">Đáp án 1</label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('answers.0') is-invalid @enderror" name="answers[]">{!! old('answers.0', $question->answers[0]->content_1) !!}</textarea>
          @error('answers.0')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="1" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $question->answers[0]->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 2</label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('answers.1') is-invalid @enderror" name="answers[]">{!! old('answers.1', $question->answers[1]->content_1) !!}</textarea>
          @error('answers.1')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="2" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $question->answers[1]->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 3</label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('answers.2') is-invalid @enderror" name="answers[]">{!! old('answers.2', $question->answers[2]->content_1) !!}</textarea>
          @error('answers.2')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="3" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $question->answers[2]->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 4</label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('answers.3') is-invalid @enderror" name="answers[]">{!! old('answers.3', $question->answers[3]->content_1) !!}</textarea>
          @error('answers.3')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="4" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $question->answers[3]->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
