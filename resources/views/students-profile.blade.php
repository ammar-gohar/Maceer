<x-layouts.app title="{{ __('general.profile') }}">
    <x-page title="{{ (App::isLocale('ar') ? 'مرحبًا، ' : 'Welcome, ') . $student->full_name }}">

        <!--begin::Body-->
        <div class="px-4 card-body">

            <div class="mb-3 row">
                <h5 class="col-sm-3 col-form-label fs-5">@lang('forms.image')</h5>
                <div class="col-sm-9 d-flex">
                    <img src="{{ asset($student->image ? 'storage/' . $student->image : 'favicon.png') }}" alt="User image" class="img-thumbnail" width="120" height="90">
                </div>
            </div>

            <livewire:components.show-item label="forms.name" :data="$student->full_name" />

            <livewire:components.show-item label="forms.national_id" :data="$student->national_id" />

            <livewire:components.show-item label="forms.email" :data="$student->email" />

            <livewire:components.show-item label="forms.phone" :data="$student->phone" />

            <livewire:components.show-item label="forms.gender" :data="$student->gender == 'm' ? __('forms.male') : __('forms.female')" />

            <livewire:components.show-item label="forms.level" :data="$student->student->level->name" />

            <livewire:components.show-item label="forms.gpa" :data="$student->student->gpa" />

            <livewire:components.show-item label="forms.total_earned_credits" :data="$student->student->total_earned_credits" />

        </div>
        <div class="card-body" style="overflow-x: scroll;">
            @if ($enrolls->count() > 0)
                @php
                    function isShown($column, $shownColumns){
                        return in_array($column, $shownColumns);
                    };
                @endphp
                @foreach ($enrolls as $semester => $enrollments)
                    <div>
                        {{ $semester }}
                    </div>
                    <table class="table-striped table mb-4 table-bordered table-sm">
                        <thead>
                            <tr class="text-nowrap">
                                <th class="text-center">#</th>
                                <th>@lang('modules.courses.code')</th>
                                <th>{{ App::isLocale('ar')  ? 'اسم المقرر' : 'Course name' }}</th>
                                <th>@lang('modules.courses.total')</th>
                                <th>@lang('modules.students.gpa')</th>
                                <th>@lang('modules.courses.grade')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollments as $enroll)
                                @php
                                    $shownColumns = explode('-', $enroll->shown_columns);
                                @endphp
                                <tr wire:key='course-{{ $loop->iteration }}' class="text-nowrap">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $enroll->course->code }}</td>
                                    <td dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">{{ $enroll->course->translated_name }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->total_mark : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->final_gpa : __('modules.courses.not_revealed') }}</td>
                                    <td>{{ isShown('total_mark', $shownColumns) ? $enroll->grade?->grade : __('modules.courses.not_revealed') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @else
                <div class="text-center alert alert-secondary fw-none">
                    <h3 class="my-0 fw-normal">@lang('modules.courses.empty')</h3>
                </div>
            @endif
        </div>
        <!--end::Body-->

    </x-page>
</x-layouts.app>