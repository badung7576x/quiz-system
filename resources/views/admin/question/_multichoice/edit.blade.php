<div class="col-lg-12 space-y-5">
  <div class="row">
    <div class="col-12">
      <div class="row mb-3">
        @error('correct_answer')
          <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <label class="col-sm-12 col-form-label">Nội dung câu hỏi <span style="color: red">*</span></label>
        <div class="col-sm-12">
          <textarea class="ckeditor1 form-control @error('content') is-invalid @enderror" name="content" rows="6">{!! old('content', $question->content) !!}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-6 col-form-label">Đáp án 1 <span style="color: red">*</span></label>
        <div class="col-sm-12">
          @php $answer1 = $question->answers[0]; @endphp
          <textarea class="ckeditor1 form-control @error('answers.' . $answer1->id) is-invalid @enderror" name="answers[{{ $answer1->id }}]" rows="3">{!! old('answers.' . $answer1->id, $answer1->content_1) !!}</textarea>
          @error('answers.'. $answer1->id)
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check d-flex justify-content-end">
            <input class="form-check-input me-2" type="radio" value="1" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $answer1->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 2 <span style="color: red">*</span></label>
        <div class="col-sm-12">
          @php $answer2 = $question->answers[1]; @endphp
          <textarea class="ckeditor1 form-control @error('answers.' . $answer2->id) is-invalid @enderror" name="answers[{{ $answer2->id }}]" rows="3">{!! old('answers.' . $answer2->id, $answer2->content_1) !!}</textarea>
          @error('answers.' . $answer2->id)
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check d-flex justify-content-end">
            <input class="form-check-input me-2" type="radio" value="2" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $answer2->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 3 <span style="color: red">*</span></label>
        <div class="col-sm-12">
          @php $answer3 = $question->answers[2]; @endphp
          <textarea class="ckeditor1 form-control @error('answers.' . $answer3->id) is-invalid @enderror" name="answers[{{ $answer3->id }}]" rows="3">{!! old('answers.' . $answer3->id, $answer3->content_1) !!}</textarea>
          @error('answers.' . $answer3->id)
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check d-flex justify-content-end">
            <input class="form-check-input me-2" type="radio" value="3" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $answer3->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Đáp án 4 <span style="color: red">*</span></label>
        <div class="col-sm-12">
          @php $answer4 = $question->answers[3]; @endphp
          <textarea class="ckeditor1 form-control @error('answers.' . $answer4->id) is-invalid @enderror" name="answers[{{ $answer4->id }}]" rows="3">{!! old('answers.' . $answer4->id, $answer4->content_1) !!}</textarea>
          @error('answers.' . $answer4->id)
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-12 mt-2">
          <div class="form-check d-flex justify-content-end">
            <input class="form-check-input me-2" type="radio" value="4" name="correct_answer" @checked(old('correct_answer') ? old('correct_answer') == 1 : $answer4->is_correct)>
            <label class="form-check-label">Đáp án đúng</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
