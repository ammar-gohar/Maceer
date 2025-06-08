<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang('modules.quizzes.index', [ 'course' => $courseName])</div>
        <div class="col-md-6">
        </div>
    </div>
    <!--end::Header-->
    <div class="card-body" style="overflow-x: scroll;">
        <div class="p-4 mx-auto card" style="width: 90%">
            <div class="d-flex justify-content-between">
                <h2 class="mb-4">{{ $quiz->title }}</h2>
                <div id="timer" class="text-center fs-5 alert alert-light" style="position:sticky; top:0;">
                    @lang('modules.quizzes.time_left'): <span id="time-remaining" wire:poll>{{ gmdate('i:s', $remainingSeconds) }}</span>
                </div>
            </div>

            @if ($submitted)
                <div class="alert alert-success">
                    @lang('modules.quizzes.submitted') {{ $quiz->attempts()->where('student_id', auth()->id())->latest()->first()->score }} / {{ $quiz->total_marks }}
                    <br />
                    <br />
                    <a href="{{ route('quizzes.index-student') }}" class="alert-link">@lang('forms.back')</a>
                </div>
            @else
                <form wire:submit.prevent="submit">
                    @foreach($questions as $index => $question)
                        <div class="p-3 mb-2 border rounded">
                            <h6 class="mb-2 fw-bold">{{ (App::isLocale('ar') ? 'س' : 'Q') . $index + 1 }}: {{ $question->question_text }}</h6>

                            @if ($question->type === 'mcq')
                                <div class="row">
                                    @foreach ($question->options as $option)
                                        <div class="px-5 form-check col-md-6">
                                            <input type="radio"
                                                wire:model="answers.{{ $question->id }}"
                                                class="form-check-input"
                                                value="{{ $option->id }}"
                                                id="q{{ $question->id }}_{{ $loop->index }}">
                                            <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($question->type === 'true_false')
                                <div class="px-5 row">
                                    <div class="form-check col-md-6">
                                        <input type="radio" wire:model="answers.{{ $question->id }}" class="form-check-input" value="true" id="true{{ $question->id }}">
                                        <label class="form-check-label" for="true{{ $question->id }}">@lang('modules.quizzes.true')</label>
                                    </div>
                                    <div class="form-check col-md-6">
                                        <input type="radio" wire:model="answers.{{ $question->id }}" class="form-check-input" value="false" id="false{{ $question->id }}">
                                        <label class="form-check-label" for="false{{ $question->id }}">@lang('modules.quizzes.false')</label>
                                    </div>
                                </div>
                            @elseif ($question->type === 'short_answer')
                                <input type="text" wire:model="answers.{{ $question->id }}" class="mt-2 form-control" placeholder="@lang('Type your answer')">
                            @elseif ($question->type === 'long_answer')
                                <textarea wire:model="answers.{{ $question->id }}" class="mt-2 form-control" rows="4" placeholder="@lang('Type your detailed answer')"></textarea>
                            @endif
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-dark">@lang('forms.submit')</button>
                </form>
            @endif
        </div>
    </div>
    <!-- /.card-body -->

</div>

<script>
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            alert("Tab switching is not allowed. Your quiz will now be submitted.");
            @this.call('submit');
        }
    });
</script>
