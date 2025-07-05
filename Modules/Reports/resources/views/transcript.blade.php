<x-layouts.reports title="{{ __('modules.reports.transcript', locale: $lang) }}" :lang="$lang">
    <div class="p-2">
        <div class="row" style="font-size: 1rem">
            <div class="mb-2 text-center col-md-12 fs-3">
                <strong>{{ __('modules.reports.transcript', locale: $lang) }}</strong>
            </div>
            <div class="mb-2 col-6">
                <strong>@lang('modules.students.name', locale: $lang):</strong> {{ $student->full_name }}
            </div>
            <div class="mb-2 col-6">
                <strong>@lang('modules.students.level', locale: $lang):</strong> {{ $student->student->level->name }}
            </div>
            <div class="mb-2 col-6">
                <strong>@lang('modules.students.gpa', locale: $lang):</strong> {{ $student->student->gpa }}
            </div>
            <div class="mb-2 col-6">
                <strong>@lang('modules.students.guide', locale: $lang):</strong> {{ $student->student->guide->full_name }}
            </div>
            <div class="mb-2 text-dark col-6">
                <strong>@lang('modules.students.core_earned_credits', locale: $lang):</strong> {{ $student->student->core_earned_credits }}
            </div>
            <div class="mb-2 text-warning-emphasis col-6">
                <strong>@lang('modules.students.university_elected_earned_credits', locale: $lang):</strong> {{ $student->student->unversity_elected_earned_credits }}
            </div>
            <div class="mb-2 text-primary col-6">
                <strong>@lang('modules.students.faculty_elected_earned_credits', locale: $lang):</strong> {{ $student->student->faculty_elected_earned_credits }}
            </div>
            <div class="mb-2 text-success col-6">
                <strong>@lang('modules.students.program_elected_earned_credits', locale: $lang):</strong> {{ $student->student->program_elected_earned_credits }}
            </div>
            <div class="mb-2 col-6">
                <strong>@lang('modules.students.total_earned_credits', locale: $lang):</strong> {{ $student->student->total_earned_credits }}
            </div>
        </div>
        <div class="mb-3 row">
            <!-- Student Info Table -->
            @foreach ($enrollments as $semester => $enrolls)
                <div class="mt-4 col-6">
                    <div class="{{ !$loop->first ? 'mt-3' : '' }}">{{ $semester }}</div>
                    <table class="table mb-4 table-bordered table-sm" style="font-size: 0.75rem;">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('modules.courses.code', locale: $lang)</th>
                                <th>@lang('modules.courses.name', locale: $lang)</th>
                                <th>@lang('modules.students.gpa', locale: $lang)</th>
                                <th>@lang('modules.courses.grade', locale: $lang)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrolls as $enroll)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $enroll->course->code ?? '--' }}</td>
                                    <td>{{ $lang == 'ar' ? $enroll->course->name_ar : $enroll->course->name }}</td>
                                    <td>{{ $enroll->final_gpa ?? '--' }}</td>
                                    <td>{{ $enroll->grade->grade ?? '--' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach

        </div>
        <div class="row">
            <div class="my-4 text-center col-6">
                <strong>{{ __('modules.reports.signature', locale: $lang) }}</strong>
            </div>
            <div class="my-4 text-center col-6">
                <strong>{{ __('modules.reports.signature', locale: $lang) }}</strong>
            </div>
        </div>
    </div>
</x-layouts.reports>
