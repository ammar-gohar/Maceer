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
                        <td>{{ $loop->iteration }}</td>
                        <td dir="ltr">{{ $quiz->title }}</td>
                        <td>{{ $quiz->attempts->count() }}</td>
                        <td>{{ $quiz->total_marks }}</td>
                        <td>{{ $quiz->start_time }}</td>
                        <td>{{ $quiz->end_time }}</td>
                        <td>
                            {{-- <a href="{{ route( 'quizzes.show-questions', $quiz->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route( 'quizzes.show-attempts', $quiz->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            --}}
                            <a href="{{ route( 'quizzes.edit', ['courseId' => $courseId, 'quizId' => $quiz->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger"
                                wire:confirm='Are you sure you want to delete this?'
                                wire:click='$delete_quiz("{{ $quiz->id }}")'
                                >
                                    <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
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

</div>
