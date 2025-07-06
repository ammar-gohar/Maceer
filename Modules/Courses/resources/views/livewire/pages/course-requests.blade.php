<x-page module="courses" title="sidebar.courses.requests">

    @if (!$semesterId || now() < $request_start || now() > $request_end)
        <div class="my-2 alert alert-dark fw-bold">
            <h5>@lang('general.unavailable_page')</h5>
        </div>
    @else
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
                <h6 class="col-6">@lang('modules.students.guide'): {{ Auth::user()->student->guide }}</h6>
                <h6 class="text-danger col-6">@lang('modules.courses.enrollment_end'): {{ Auth::user()-> }}</h6>
            </div>
        </div>
        <!--begin::Form-->
        <form wire:submit='save_requests()'>
            @csrf
            <!--begin::Body-->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.courses.code')</th>
                        <th>@lang('modules.courses.name_ar')</th>
                        <th>@lang('modules.courses.name_en')</th>
                        <th>@lang('modules.courses.level')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @php
                            if($course->type == 'core') {
                                $text_color = 'text-dark';
                            } else if ($course->requirement == 'university') {
                                $text_color = 'text-warning-emphasis';
                            } else if ($course->requirement == 'faculty') {
                                $text_color = 'text-primary';;
                            } else if ($course->requirement ==  'program') {
                                $text_color = 'text-success';
                            }
                        @endphp
                        <tr class="align-middle" style="overflow-x: scroll;">
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td class="text-center">{{ $course->code }}</td>
                            <td dir="rtl" class="{{ $text_color }}">{{ $course->name_ar }}</td>
                            <td dir="ltr" class="{{ $text_color }}">{{ $course->name }}</td>
                            <td>{{ $course->level->name }}</td>
                            <td>
                                @if (in_array($course->id, $courses_to_enroll))
                                    <button type="button" class="btn" wire:click='remove_request("{{ $course->id }}")'>
                                        <i class="fa-solid fa-xmark text-danger fs-4"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn" wire:click='add_request("{{ $course->id }}")'>
                                        <i class="fa-solid fa-plus text-success fs-4"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="mt-3 card-footer">
                <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='save_requests'>
                    <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='save_requests'>
                        <span class="text-sm visually-hidden"></span>
                    </div>
                    <span wire:loading wire:target='save_requests'>@lang('forms.submitting')</span>
                    <span wire:loading.remove wire:target='save_requests'>@lang('forms.submit')</span>
                </button>
                <button type="reset" class="border btn btn-light" wire:click='reset()'>@lang('forms.reset')</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    @endif

</x-page>
