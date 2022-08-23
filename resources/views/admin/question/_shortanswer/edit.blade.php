<div class="col-lg-12 space-y-5">
  <div class="row">
    <div class="col-12">
      <div class="row mb-3">
        <label class="col-sm-12 col-form-label">Nội dung câu hỏi <span style="color: red">*</span></label>
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
        <label class="col-8 col-form-label mb-2">Nội dung đáp án <span style="color: red">*</span></label>
        <div class="col-12" id="content-area">
          @php $answer = $question->answers->first() @endphp
          <div class="row mb-4">
            <div class="col-12">
              <textarea class="form-control @error('answers.' . $answer->id ) is-invalid @enderror" name="answers[{{ $answer->id }}]">{{ old('answers.' . $answer->id, $answer->content_1) }}</textarea>
              @error('answers.' . $answer->id)
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
