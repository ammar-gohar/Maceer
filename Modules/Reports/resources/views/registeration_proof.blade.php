<x-layouts.reports title="{{ __('modules.reports.registeration_proof', locale: $lang) }}" :lang="$lang">
    <div class="p-5">
        <div class="row" style="font-size: 1rem">
            <div class="mb-3 text-center col-12 fs-3">
                <strong>{{ __('modules.reports.registeration_proof', locale: $lang) }}</strong>
            </div>

            <!-- Student Image -->
            <div class="mb-3 text-center col-12">
                <img src="{{ asset($student->image ? ('storage/' . $student->image) : ('favicon.png')) }}" alt="Student Image" height="120">
            </div>

            <!-- Basic Student Info -->
            <div class="mb-3 col-12">
                <strong>@lang('modules.students.name', locale: $lang): </strong>{{ $student->full_name }}
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.students.academic_number', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $student->student->academic_number }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.students.level', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $student->student->level->name }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.semester.semester', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $semester->name }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.semester.year', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ \Carbon\Carbon::parse($semester->created_at)->format('Y') . '-' . \Carbon\Carbon::parse($semester->created_at)->addYear()->format('Y')}}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.students.national_id', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $student->student->national_id }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.students.gpa', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $student->student->gpa }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.students.total_earned_credits', locale: $lang):</strong>
                </div>
                <div class="col-5">
                    {{ $student->student->total_earned_credits }}
                </div>
            </div>
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>@lang('modules.courses.grade', locale: $lang): </strong>
                </div>
                <div class="col-5">
                    {{ $student->student?->grade?->grade ?? '--' }}
                </div>
            </div>
            @if ($request->directed_to)
                <div class="mb-3 row col-6">
                    <div class="col-7">
                        <strong>{{ App::isLocale('ar') ? 'موجه إلى' : 'Directed to' }}: </strong>
                    </div>
                    <div class="col-5">
                        {{ $request->directed_to }}
                    </div>
                </div>
            @endif
            <div class="mb-3 row col-6">
                <div class="col-7">
                    <strong>{{ App::isLocale('ar') ? 'تاريخ الطباعة' : 'Print Date' }}: </strong>
                </div>
                <div class="col-5">
                    {{ now()->format('Y-m-d') }}
                </div>
            </div>
        </div>

        <!-- Signature Section -->
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
