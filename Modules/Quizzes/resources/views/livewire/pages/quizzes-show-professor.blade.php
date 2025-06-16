<!--end::Header-->
<div class="card-body" style="overflow-x: scroll;">
    <div class="p-4 mx-auto card" style="width: 90%">
        <div class="d-flex justify-content-between">
            <h2 class="mb-4">{{ $quiz->title }}</h2>
            <h4>
                @lang('modules.quizzes.score'): {{ $attempt->score }}
            </h4>
            <h4>
                @lang('modules.quizzes.submitted_at'): {{ $attempt->submitted_at }}
            </h4>
        </div>
            <div>
                @foreach($quiz->questions as $index => $question)
                    @php
                        $studentAnswer = $answers->where('question_id', $question->id)->first();
                        debugbar()->info($errors->all());
                    @endphp
                    <div class="p-3 mb-2 border rounded">
                        <div class="mb-3 d-flex justify-content-between">
                            <h6 class="mb-2 fw-bold">
                                {{ (App::isLocale('ar') ? 'س' : 'Q') . $index + 1 }}: {{ $question->question_text }}
                            </h6>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span>@lang('modules.quizzes.score'): </span>
                                    <input 
                                        type="number" 
                                        min="0" 
                                        max="{{ $question->marks }}" 
                                        step="0.5" 
                                        class="form-control" 
                                        wire:model.fill.number.live='mark' 
                                        value="{{ $studentAnswer?->marks_obtained ?: 0 }}" 
                                        style="display:inline; max-width:63px;">
                                    <span>/ {{ $question->marks }}</span>
                                </div>
                                
                                <button wire:click='change_mark(["{{ $studentAnswer?->id }}"])' class="btn btn-dark">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </div>
                        </div>
                        @if ($question->type === 'mcq')
                            <div class="row">
                                @foreach ($question->options as $option)
                                    <div class="px-5 col-md-6">
                                        <h6
                                            id="q{{ $question->id }}_{{ $loop->index }}"
                                            @class(['text-black', 'text-decoration-underline fw-bolder' => $studentAnswer?->selected_option_id == $option->id])>
                                            @if ($studentAnswer?->selected_option_id == $option->id)
                                                @if ($studentAnswer?->is_correct)
                                                    <i class="fa-solid fa-check text-success me-2"></i>
                                                @else
                                                    <i class="fa-solid fa-x text-danger me-2"></i>
                                                @endif
                                            @endif
                                            {{ $option->option_text }}
                                        </h6>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->type === 'true_false')
                            <div class="px-5 row">
                                <h6
                                    id="true{{ $question->id }}"
                                    @class(['text-black', 'text-decoration-underline fw-bolder' => $studentAnswer?->answer_text == 'true'])>
                                    @if ($studentAnswer?->answer_text == 'true')
                                        @if ($studentAnswer?->is_correct)
                                            <i class="fa-solid fa-check text-success me-2"></i>
                                        @else
                                            <i class="fa-solid fa-x text-danger me-2"></i>
                                        @endif
                                    @endif
                                    @lang('modules.quizzes.true')
                                </h6>
                                <h6
                                    id="false{{ $question->id }}"
                                    @class(['text-black', 'text-decoration-underline fw-bolder' => $studentAnswer?->answer_text == 'false'])>
                                    @if ($studentAnswer?->answer_text == 'false')
                                        @if ($studentAnswer?->is_correct)
                                            <i class="fa-solid fa-check text-success me-2"></i>
                                        @else
                                            <i class="fa-solid fa-x text-danger me-2"></i>
                                        @endif
                                    @endif
                                    @lang('modules.quizzes.false')
                                </h6>
                            </div>
                        @elseif (in_array($question->type, ['short_answer', 'long_answer']))
                            <p class="mt-2 alert {{ $studentAnswer?->is_correct ? 'alert-success' : 'alert-danger' }}">
                                {{ $studentAnswer->answer_text }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
    </div>
</div>
<!-- /.card-body -->
