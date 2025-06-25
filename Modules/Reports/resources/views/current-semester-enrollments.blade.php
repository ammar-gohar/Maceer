<x-layouts.reports title="{{ App::isLocale('ar') ? 'تسجيل المقررات' : 'Enrollments' }}">
    <div class="mb-2 row">
        <div class="mb-4 text-center col-md-12 fs-3">
            <strong>{{ App::isLocale('ar') ? 'تسجيل المقررات' : 'Enrollments' }}</strong>
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
    <div class="mb-3">
        <div class="mb-2 col-md-12 text-danger" style="font-size: 0.75rem;">
            <strong>@lang('modules.students.approved_at'):</strong> {{ $student->current_enrollments->first()->approved_at ?? '--' }}
        </div>
        <!-- Student Info Table -->
        <table class="table mb-4 table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>@lang('modules.courses.code')</th>
                    <th>@lang('modules.courses.name')</th>
                    <th>@lang('modules.courses.level')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->current_enrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->course->code ?? '--' }}</td>
                        <td>{{ $enrollment->course->translated_name ?? '--' }}</td>
                        <td>{{ $enrollment->course->level->name ?? '--' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layouts.reports>
