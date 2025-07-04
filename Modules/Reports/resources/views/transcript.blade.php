<x-layouts.reports title="{{ __('modules.reports.transcript', locale: $lang) }}">
    <div class="row">
        <div class="mb-4 text-center col-md-12 fs-3">
            <strong>{{ __('modules.reports.transcript', locale: $lang) }}</strong>
        </div>
        <div class="mb-4 col-md-6">
            <strong>@lang('modules.students.name'):</strong> {{ $student->full_name }}
        </div>
        <div class="mb-4 col-md-6">
            <strong>@lang('modules.students.level'):</strong> {{ $student->student->level->name }}
        </div>
        <div class="mb-4 col-md-6">
            <strong>@lang('modules.students.gpa'):</strong> {{ $student->student->gpa }}
        </div>
        <div class="mb-4 col-md-6">
            <strong>@lang('modules.students.guide'):</strong> {{ $student->student->guide->full_name }}
        </div>
    </div>
    <div class="mb-2 row">
        <div class="mb-2 row">
            <div class="container">
                <div class="row">
                    <p class="text-dark col-6">
                        <strong>@lang('modules.students.core_earned_credits'):</strong> {{ $student->student->core_earned_credits }}
                    </p>
                    <p class="text-warning-emphasis col-6">
                        <strong>@lang('modules.students.university_elected_earned_credits'):</strong> {{ $student->student->unversity_elected_earned_credits }}
                    </p>
                </div>
                <div class="row">
                    <p class="text-primary col-6">
                        <strong>@lang('modules.students.faculty_elected_earned_credits'):</strong> {{ $student->student->faculty_elected_earned_credits }}
                    </p>
                    <p class="text-success col-6">
                        <strong>@lang('modules.students.program_elected_earned_credits'):</strong> {{ $student->student->program_elected_earned_credits }}
                    </p>
                </div>
                <div class="row">
                    <p><strong>@lang('modules.students.total_earned_credits'):</strong> {{ $student->student->total_earned_credits }}</p>
                </div>
            </div>
        </div>
        <div class="mb-2 row">
        </div>
    </div>
    <div class="mb-3">
        <!-- Student Info Table -->
        <table class="table mb-4 table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>@lang('modules.courses.code')</th>
                    <th>@lang('modules.courses.name')</th>
                    <th>@lang('modules.courses.level')</th>
                    <th>@lang('modules.students.gpa')</th>
                    <th>@lang('modules.courses.grade')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->enrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->course->code ?? '--' }}</td>
                        <td>{{ $enrollment->course->translated_name ?? '--' }}</td>
                        <td>{{ $enrollment->course->level->name ?? '--' }}</td>
                        <td>{{ $enrollment->final_gpa ?? '--' }}</td>
                        <td>{{ $enrollment->grade->grade ?? '--' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layouts.reports>
