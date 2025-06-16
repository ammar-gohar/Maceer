<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang('modules.quizzes.index-student')</div>
    </div>
    <!--end::Header-->
    <div class="card-body" style="overflow-x: scroll; white-space: nowrap;">
        @if ($quizzes->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.courses.course')</th>
                        <th>@lang('modules.quizzes.title')</th>
                        <th>@lang('modules.quizzes.score')</th>
                        <th>@lang('modules.quizzes.total_mark')</th>
                        <th>@lang('modules.quizzes.starts_at')</th>
                        <th>@lang('modules.quizzes.ends_at')</th>
                        <th>@lang('modules.quizzes.duration_minutes')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        @php
                            $studentAttempt = $quiz->studentAttempt(Auth::id())->first()
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quiz->course->name }}</td>
                            <td dir="ltr">{{ $quiz->title }}</td>
                            <td>{{ $studentAttempt?->score ?? __('modules.quizzes.not_taken') }}</td>
                            <td>{{ $quiz->total_marks }}</td>
                            <td dir="ltr">{{ \Carbon\Carbon::parse($quiz->start_time)->format('Y-m-d, h:i A') }}</td>
                            <td dir="ltr">{{ \Carbon\Carbon::parse($quiz->end_time)->format('Y-m-d, h:i A') }}</td>
                            <td>{{ $quiz->duration_minutes }}</td>
                            <td>
                                @if (\Carbon\Carbon::now() < $quiz->start_time)
                                    <div>
                                        @lang('modules.quizzes.starts_at')
                                        <span dir="ltr">{{ \Carbon\Carbon::parse($quiz->start_time)->format('Y-m-d, h:i A') }}</span>
                                    </div>
                                @elseif ($studentAttempt?->submitted_at !== null)
                                    <div>
                                        @lang('modules.quizzes.submitted_at')
                                        <span dir="ltr">{{ \Carbon\Carbon::parse($studentAttempt->submitted_at)->format('Y-m-d, h:i A') }}</span>
                                    </div>
                                @elseif (\Carbon\Carbon::now() > $quiz->end_time)
                                    <div>
                                        @lang('modules.quizzes.quiz_ended')
                                    </div>
                                @else
                                    <div>
                                        <button type="button" class="btn btn-primary" wire:click='show_modal("{{ $quiz->id }}")'>
                                            <i class="fa-solid fa-pen "></i>
                                            @lang('modules.quizzes.take_quiz')
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.quizzes.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    @if ($showModal)
        @if (App::isLocale('en'))
            <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="px-3 modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> Notes befor you enter the exam</h5>
                        </div>
                        <div class="px-4 modal-body">
                            <ul>
                                <li>The quiz has a specific duration. When it's finished, the quiz will be atuomatically <strong>submitted</strong></li>
                                <li>You can't change tabs or the page. If you did, the quiz will be atuomatically <strong>submitted</strong></li>
                            </ul>
                        </div>
                        <div class="px-3 modal-footer">
                            <a href="{{ route('quizzes.show-student', $showModal) }}" class="btn btn-dark">
                                <i class="fa-solid fa-pen "></i>
                                @lang('modules.quizzes.take_quiz')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="px-3 modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> تحذيرات قبل الدخول للامتحان</h5>
                        </div>
                        <div class="px-4 modal-body">
                            <ul>
                                <li>للامتحان وقت محدد للإجابة، عند انتهاء الوقت سيتم تثبيت <strong>تثبيت الإجابة</strong> بشكل تلقائي</li>
                                <li>لا يمكنك الانتقال بين الصفحات أو تغيير الصفحة أثناء الامتحان وإلا  سيعتبر الامتحان <strong>منتهيًا</strong></li>
                            </ul>
                        </div>
                        <div class="px-3 modal-footer">
                            <a href="{{ route('quizzes.take-quiz', $showModal) }}" class="btn btn-dark">
                                <i class="fa-solid fa-pen "></i>
                                @lang('modules.quizzes.take_quiz')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

</div>
