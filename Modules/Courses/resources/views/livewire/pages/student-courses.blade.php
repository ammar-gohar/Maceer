<x-page title="sidebar.courses.student-show" module="courses">

    <div class="card-body" style="overflow-x: scroll;">
        @if (!$semesterId)
            <div class="alert alert-dark fs-4">
                @lang('general.unavailable_page')
            </div>
        @elseif (Auth::user()->current_enrollments->count() == 0)
            <div class="alert alert-dark fs-4">
                {{ App::isLocale('ar') ? 'لم تسجل أي مقرر هذا الفصل' : 'You didn\'t enroll in any courses this semester' }}
            </div>
        @else
            <div class="container my-3">
                <div class="mb-2 row">
                    <a href="{{ route('reports.current.enrollment', ['semesterId' => $semesterId, 'studentId' => Auth::id()]) }}" target="_blank" class="w-auto btn btn-dark">
                        <i class="fa-solid fa-print"></i>
                    </a>
                </div>
                <div class="mb-2 row">
                    <h5 class="col-6"><strong>@lang('modules.students.gpa'):</strong> {{ Auth::user()->student->gpa }}</h5>
                    <h5 class="col-6"><strong>@lang('modules.students.total_earned_credits'):</strong> {{ Auth::user()->student->total_earned_credits }}</h5>
                </div>
                <div class="mb-2 row">
                    <div class="container">
                        <div class="row">
                            <p class="text-dark col-6">
                                <strong>@lang('modules.students.core_earned_credits'):</strong> {{ Auth::user()->student->core_earned_credits }}
                            </p>
                            <p class="text-warning-emphasis col-6">
                                <strong>@lang('modules.students.university_elected_earned_credits'):</strong> {{ Auth::user()->student->unversity_elected_earned_credit }}
                            </p>
                        </div>
                        <div class="row">
                            <p class="text-primary col-6">
                                <strong>@lang('modules.students.faculty_elected_earned_credits'):</strong> {{ Auth::user()->student->faculty_elected_earned_credits }}
                            </p>
                            <p class="text-success col-6">
                                <strong>@lang('modules.students.program_elected_earned_credits'):</strong> {{ Auth::user()->student->program_elected_earned_credits }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-2 row">
                    <h6 class="col-6">@lang('modules.students.guide'): {{ Auth::user()->student->guide->full_name }}</h6>
                    <h6 class="text-danger col-6">@lang('modules.courses.enrollment_end'): {{ $enrollmentEnd }}</h6>
                </div>
            </div>
            @if ($enrolls->count() > 0)
                <div class="mb-2 col-md-12 text-danger" style="font-size: 0.75rem;">
                    <strong>@lang('modules.students.approved_at'):</strong>
                    @if (!$receipt->paied_at)
                        {{ App::isLocale('ar') ? 'لا يمكن التصديق على التسجيل دون الدفع' : 'Enrollments can\'t be approved before payment' }}
                    @else
                        {{ $enrolls->first()->approved_at ?? (App::isLocale('ar') ? 'في انتظار التصديق' : 'Waiting for approvement') }}
                    @endif
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-nowrap">
                            <th class="text-center">#</th>
                            <th>@lang('modules.courses.code')</th>
                            <th>{{ App::isLocale('ar')  ? 'اسم المقرر' : 'Course name' }}</th>
                            @if ($receipt->paied_at)
                                <th>@lang('modules.courses.midterm_exam')</th>
                                <th>@lang('modules.courses.work_mark')</th>
                                <th>@lang('modules.courses.final_exam')</th>
                                <th>@lang('modules.courses.total')</th>
                                <th>@lang('modules.students.gpa')</th>
                                <th>@lang('modules.courses.grade')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            function isShown($column, $shownColumns){
                                return in_array($column, $shownColumns);
                            };
                        @endphp
                        @foreach ($enrolls as $enroll)
                            @php
                                $shownColumns = explode('-', $enroll->shown_columns);
                            @endphp
                            <tr wire:key='course-{{ $loop->iteration }}' class="text-nowrap">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $enroll->course->code }}</td>
                                <td dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">{{ $enroll->course->name }}</td>
                                @if ($receipt->paied_at)
                                    <td>{{ isShown('midterm_exam', $shownColumns) ? $enroll->midterm_exam : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('work_marks', $shownColumns) ? $enroll->work_mark : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('final_exam', $shownColumns) ? $enroll->final_exam : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->total_mark : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->final_gpa : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->grade?->grade : __('modules.courses.not_revealed') }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center alert alert-secondary fw-none">
                    <h3 class="my-0 fw-normal">@lang('modules.courses.empty')</h3>
                </div>
            @endif
        @endunless
    </div>

</x-page>
