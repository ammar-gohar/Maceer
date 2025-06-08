<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang('modules.quizzes.index', [ 'course' => $courseName])</div>
        <div class="col-md-6">
            <a href="{{ route('courses.quizzes', ['courseId' => $courseId]) }}" class="mb-2 float-end btn btn-dark me-2"><i class="mx-1 fa-solid fa-eye"></i> @lang('sidebar.quizzes.index')</a>
        </div>
    </div>
    <!--end::Header-->

    <div class="card-body" style="overflow-x: scroll;">
        <form wire:submit='add_quiz()'>
            @csrf
            <!--begin::Body-->
            @if ($currentTab['show'] == 1)
                <div class="card-body" id="addCourseFirst">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <x-form-input name="title" wire_model="title"/>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <x-form-input name="duration" type="number" wire_model="duration_minutes" min="0" />
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="px-2">
                            <label for="description" class="form-label">@lang("forms.description")</label>
                            <textarea name="description" class="mt-0 form-control col-6" id="description" cols="30" rows="2" wire:model='description'>
                            </textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <x-form-input name="start_date" type="datetime-local" wire_model="start_time" />
                        <!--end::Col-->
                        <!--begin::Col-->
                        <x-form-input name="end_date" type="datetime-local" wire_model="end_time" />
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
            @elseif ($currentTab['show'] == 2)
            @php
                debugbar()->info($errors->all());
            @endphp
                <div class="card-body" >
                    <!--begin::Row-->
                    <div class="row g-3">
                        <div class="fs-sm col-12">
                            @foreach ($questions as $index => $question)
                                <div class="my-3 border shadow-sm card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>@lang('modules.quizzes.question') {{ $index + 1 }}</strong>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" wire:click="moveUp({{ $index }})" title="Move Up"><i class="fas fa-arrow-up"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" wire:click="moveDown({{ $index }})" title="Move Down"><i class="fas fa-arrow-down"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeQuestion({{ $index }})" title="Remove"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-10">
                                                <label class="form-label">@lang('modules.quizzes.question_text') *</label>
                                                <input type="text" class="form-control" wire:model.change="questions.{{ $index }}.question_text" placeholder="@lang('modules.quizzes.enter_question')">
                                                @error('questions.{{ $index }}.question_text')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">@lang('modules.quizzes.mark') *</label>
                                                <input type="number" class="form-control" wire:model.change="questions.{{ $index }}.mark" placeholder="1">
                                                @error('questions.{{ $index }}.mark')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">@lang('modules.quizzes.question_type.title') *</label>
                                            <select class="form-select" wire:model.change="questions.{{ $index }}.type">
                                                <option value="mcq">@lang('modules.quizzes.question_type.mcq')</option>
                                                <option value="true_false">@lang('modules.quizzes.question_type.true_false')</option>
                                                <option value="short_answer">@lang('modules.quizzes.question_type.short_answer')</option>
                                                <option value="long_answer">@lang('modules.quizzes.question_type.long_answer')</option>
                                            </select>
                                            @error('questions.{{ $index }}.type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        @if ($question['type'] === 'mcq')
                                            <div class="row">
                                                @foreach (['A', 'B', 'C', 'D'] as $optIdx => $label)
                                                    <div class="mb-2 col-md-6">
                                                        <label class="form-label">@lang('modules.quizzes.option') {{ $label }}</label>
                                                        <input type="text" class="form-control" wire:model.change="questions.{{ $index }}.options.{{ $optIdx }}.option_text">
                                                        @error('questions.{{ $index }}.options.{{ $optIdx }}.option_text')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">@lang('modules.quizzes.correct_answer') *</label>
                                                <div class="row">
                                                    @foreach (['A', 'B', 'C', 'D'] as $label)
                                                        <div class="mb-2 col-md-6 form-check ps-5">
                                                            <input type="radio"
                                                            name="questions.{{ $index }}.correct_answer"
                                                            class="form-check-input"
                                                            wire:model.change="questions.{{ $index }}.correct_answer"
                                                            id="questions.{{ $index }}.correct_answer.{{ $label }}"
                                                            value="{{ $loop->iteration - 1 }}">
                                                            <label for="questions.{{ $index }}.correct_answer.{{ $label }}" class="form-check-label">{{ $label . ' - ' . $questions[$index]['options'][$loop->iteration - 1]['option_text'] }}</label>
                                                        </div>
                                                    @endforeach
                                                    @error('questions.{{ $index }}.correct_answer')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($question['type'] === 'true_false')
                                            <div class="mb-3">
                                                <label class="form-label">@lang('modules.quizzes.correct_answer')</label>
                                                <div class="row">
                                                    <div class="mb-2 col-md-6 form-check ps-5">
                                                        <input type="radio"
                                                        name="questions.{{ $index }}.correct_answer"
                                                        class="form-check-input"
                                                        id="questions.{{ $index }}.correct_answer.true"
                                                        wire:model.change="questions.{{ $index }}.correct_answer"
                                                        value="true">
                                                        <label for="questions.{{ $index }}.correct_answer.true" class="form-check-label"><i class="fa fa-check text-success" aria-hidden="true"></i> @lang('modules.quizzes.true')</label>
                                                    </div>
                                                    <div class="mb-2 col-md-6 form-check ps-5">
                                                        <input type="radio"
                                                        name="questions.{{ $index }}.correct_answer"
                                                        class="form-check-input"
                                                        wire:model.change="questions.{{ $index }}.correct_answer"
                                                        id="questions.{{ $index }}.correct_answer.false"
                                                        value="false">
                                                        <label for="questions.{{ $index }}.correct_answer.false" class="form-check-label"><i class="fa fa-x text-danger" aria-hidden="true"></i> @lang('modules.quizzes.false')</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($question['type'] === 'short_answer')
                                            <div class="mb-3">
                                                <label class="form-label">@lang('modules.quizzes.correct_answer')</label>
                                                <input type="text" class="form-control" wire:model.change="questions.{{ $index }}.correct_answer">
                                                @error('questions.{{ $index }}.correct_answer')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @elseif ($question['type'] === 'long_answer')
                                            <div class="mb-3">
                                                <label class="form-label">@lang('modules.quizzes.correct_answer')</label>
                                                <textarea class="form-control" rows="3" wire:model.change="questions.{{ $index }}.correct_answer"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                <button type="button" class="btn btn-dark" wire:click="addQuestion">
                                    <i class="fas fa-plus me-1"></i> @lang('modules.quizzes.add_question')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!--end::Body-->

            <!--begin::Footer-->
            <div class="mt-3 card-footer">
                @if ($currentTab['show'] == 2)
                    <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='add_quiz'>
                        <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='add_quiz'>
                            <span class="text-sm visually-hidden"></span>
                        </div>
                        <span wire:loading wire:target='add_quiz'>@lang('forms.creating')</span>
                        <span wire:loading.remove wire:target='add_quiz'>@lang('forms.create')</span>
                    </button>
                @endif
                <button type="button" class="border btn {{ $currentTab['show'] == 1 ? 'btn-dark' : 'btn-light' }}" type="submit" wire:click="change_tab()" wire:loading.attr='disabled'>
                    <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='change_tab'>
                        <span class="text-sm visually-hidden"></span>
                    </div>
                    <span>{{ $currentTab['btn'] }}</span>
                </button>
                <button type="reset" class="border btn btn-light" wire:click='reset()'>@lang('forms.reset')</button>
            </div>
            <!--end::Footer-->
        </form>
    </div>
    <!-- /.card-body -->

</div>
