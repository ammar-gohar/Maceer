<x-page title="sidebar.courses.student-show" module="courses">

    <div class="container my-3">
        <div class="mb-2 row">
            <h5 class="col-6">@lang('modules.students.gpa'): {{ Auth::user()->student->gpa }}</h5>
            <h5 class="col-6">@lang('modules.students.total_earned_credits'): {{ Auth::user()->student->total_earned_credits }}</h5>
        </div>
        <div class="mb-2 row">
            <div class="container">
                <div class="row">
                    <p class="text-dark col-6">
                        @lang('modules.students.core_earned_credits'): {{ Auth::user()->student->core_earned_credits }}
                    </p>
                    <p class="text-warning-emphasis col-6">
                        @lang('modules.students.university_elected_earned_credits'): {{ Auth::user()->student->university_elected_earned_credits }}
                    </p>
                </div>
                <div class="row">
                    <p class="text-primary col-6">
                        @lang('modules.students.faculty_elected_earned_credits'): {{ Auth::user()->student->faculty_elected_earned_credits }}
                    </p>
                    <p class="text-success col-6">
                        @lang('modules.students.program_elected_earned_credits'): {{ Auth::user()->student->program_elected_earned_credits }}
                    </p>
                </div>
            </div>
        </div>
        <div class="mb-2 row">
            <h6 class="col-6">@lang('modules.students.head_professor'):</h6>
            <h6 class="text-danger col-6">@lang('modules.courses.enrollment_end'):</h6>
        </div>
    </div>
    <div class="card-body" style="overflow-x: scroll;">
        @if ($enrolls->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-nowrap">
                        <th class="text-center">#</th>
                        <th>@lang('modules.courses.code')</th>
                        <th>{{ App::isLocale('ar')  ? 'اسم المقرر' : 'Course name' }}</th>
                        <th>@lang('modules.courses.midterm_exam')</th>
                        <th>@lang('modules.courses.work_mark')</th>
                        <th>@lang('modules.courses.final_exam')</th>
                        <th>@lang('modules.courses.total')</th>
                        <th>@lang('modules.students.gpa')</th>
                        <th>@lang('modules.courses.grade')</th>
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
                            <td>{{ isShown('midterm_exam', $shownColumns) ? $enroll->midterm_exam : __('modules.courses.not_revealed') }}</td>
                            <td>{{ isShown('work_marks', $shownColumns) ? $enroll->work_mark : __('modules.courses.not_revealed') }}</td>
                            <td>{{ isShown('final_exam', $shownColumns) ? $enroll->final_exam : __('modules.courses.not_revealed') }}</td>
                            <td>{{ isShown('total_mark', $shownColumns) ? $enroll->total_mark : __('modules.courses.not_revealed') }}</td>
                            <td>{{ isShown('total_mark', $shownColumns) ? $enroll->final_gpa : __('modules.courses.not_revealed') }}</td>
                            <td>{{ isShown('total_mark', $shownColumns) ? $enroll->grade?->grade : __('modules.courses.not_revealed') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.courses.empty')</h3>
            </div>
        @endif
    </div>

</x-page>
