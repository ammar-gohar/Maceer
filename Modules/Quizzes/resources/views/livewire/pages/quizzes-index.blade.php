<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang('modules.quizzes.index', [ 'course' => $courseName])</div>
        <div class="col-md-6">
            <a href="{{ route('quizzes.create', ['courseId' => $courseId]) }}" class="mb-2 float-end btn btn-dark me-2"><i class="mx-1 fa-solid fa-plus"></i> @lang('modules.quizzes.create')</a>
        </div>
    </div>
    <!--end::Header-->
    <div class="card-body" style="overflow-x: scroll;">
        @if ($quizzes->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.quizzes.title')</th>
                        <th>@lang('modules.quizzes.taken_count')</th>
                        <th>@lang('modules.quizzes.total_mark')</th>
                        <th>@lang('modules.quizzes.starts_at')</th>
                        <th>@lang('modules.quizzes.ends_at')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td dir="ltr">{{ $quiz->title }}</td>
                            <td>{{ $quiz->attempts->count() }}</td>
                            <td>{{ $quiz->total_marks }}</td>
                            <td>{{ $quiz->start_time }}</td>
                            <td>{{ $quiz->end_time }}</td>
                            <td>
                                @if (Carbon\Carbon::now() > $quiz->finish_time)
                                    <button type="button" class="btn btn-sm btn-secondary" wire:click='showModal("index", "{{ $quiz->id }}")'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                @endif
                                @if (Carbon\Carbon::now() < $quiz->start_time)
                                    <a href="{{ route( 'quizzes.edit', ['courseId' => $courseId, 'quizId' => $quiz->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger"
                                        wire:confirm='Are you sure you want to delete this?'
                                        wire:click='$delete_quiz("{{ $quiz->id }}")'
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                    </button>
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

    @if ($attempts_index || $attempt_show)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog" style="max-width:75%;">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">
                            @lang('modules.quizzes.attempts_index')
                        </h5>
                    </div>
                    <div class="px-4 modal-body">
                        @if ($attempt_show)
                            <livewire:quizzes::pages.quizzes-show-professor
                                :quiz="$attempt_show->quiz"
                                :attempt="$attempt_show->attempt"
                                :answers="$attempt_show->attempt->answers">
                        @elseif ($attempts_index)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>@lang('modules.quizzes.submitted_at')</th>
                                        <th>@lang('modules.quizzes.score')</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attempts_index as $attempt)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attempt->submitted_at }}</td>
                                            <td>{{ $attempt->score }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary" wire:click='showModal("show", "{{ $attempt->id }}")'>
                                                    <i class="fa-solid fa-eye"></i>
                                                    {{ App::isLocale('ar') ? 'عرض' : 'Show' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="px-3 modal-footer">
                        <button type="button" wire:click='closeModal()' class="btn btn-light">
                            @lang('forms.close')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
