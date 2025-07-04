<x-page title="sidebar.courses.schedule" module="courses">
    <div class="container card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="my-3">
                <div class="mb-2 d-flex justify-content-between">
                    <h5>@lang('modules.students.credits_to_enroll'): {{ Auth::user()->student->maximum_credits_to_enroll - $student_enrolled_credits }}</h5>
                    <h5>@lang('modules.students.gpa'): {{ Auth::user()->student->gpa }}</h5>
                    <h5>@lang('modules.students.total_earned_credits'): {{ Auth::user()->student->gpa }}</h5>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <h6><strong>@lang('modules.students.guide'):</strong> {{ Auth::user()->student->guide->full_name }}</h6>
                    <h6 class="text-danger"><strong>@lang('modules.courses.enrollment_end'):</strong>{{ $enrollments_end_date }}</h6>
                </div>
                @if (now() > $enrollments_end_date)
                    <div class="mb-2 d-flex justify-content-between">
                        <h4>@lang('modules.courses.enrollments_ended')</h4>
                    </div>
                @endif
            </div>
            <div class="schedule-table" style="overflow-x: scroll;">
              <table class="bg-white">
                <thead>
                  <tr class="bg-dark">
                    <th class="last">@lang('sidebar.courses.title')</th>
                    <th>
                        1 - 2 <br>
                        <span style="font-size: 12px;">09:00 - 10:50 {{ App::isLocale('ar') ? 'ص' : 'am' }}</span>
                    </th>
                    <th>
                        3 - 4 <br>
                        <span style="font-size: 12px;">10:50 - 12:40 {{ App::isLocale('ar') ? 'م' : 'pm' }}</span>
                    </th>
                    <th>
                        5 - 6 <br>
                        <span style="font-size: 12px;">01:00 - 02:50 {{ App::isLocale('ar') ? 'م' : 'pm' }}</span>
                    </th>
                    <th>
                        7 - 8 <br>
                        <span style="font-size: 12px;">02:50 - 03:40 {{ App::isLocale('ar') ? 'م' : 'pm' }}</span>
                    </th>
                    <th>
                        9 - 10 <br>
                        <span style="font-size: 12px;">03:40 - 04:30 {{ App::isLocale('ar') ? 'م' : 'pm' }}</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="day">@lang('general.saturday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='saturday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['saturday']))
                                    @foreach ($schedules['saturday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='saturday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) ||($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>
                    <tr>
                        <td class="day">@lang('general.sunday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='sunday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['sunday']))
                                    @foreach ($schedules['sunday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='sunday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) || ($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.monday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='monday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['monday']))
                                    @foreach ($schedules['monday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='monday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) || ($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.tuesday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='tuesday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['tuesday']))
                                    @foreach ($schedules['tuesday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='tuesday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) || ($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.wednesday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='wednesday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['wednesday']))
                                    @foreach ($schedules['wednesday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='wednesday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) || ($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>

                    <tr>

                        <td class="day">@lang('general.thursday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='thursday-{{ $i }}' style="min-width: 140px;">
                                @if (isset($schedules['thursday']))
                                    @foreach ($schedules['thursday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='thursday-{{ $i }}-{{ $loop->iteration }}'>
                                            @php
                                                $courseEnrollment = Auth::user()->enrollments->where('course_id', $course->course->id)->first();
                                            @endphp
                                            <div>
                                                <h4
                                                    @class([
                                                        'text-success' => $courseEnrollment && $courseEnrollment->schedule_id == $course->id,
                                                        'text-danger' => $courseEnrollment && $courseEnrollment->final_gpa != null && $courseEnrollment->final_gpa <= 1,
                                                        ])
                                                    >{{ $course->course->translated_name }} ({{ $course->course->level->name }})</h4>

                                                <p>{{ $course->professor->full_name }}</p>

                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>

                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number - $course->students_enrollments_number }})</span>

                                                @if ($courseEnrollment && $courseEnrollment->final_gpa)
                                                    <span>({{ $courseEnrollment->final_gpa }})</span>
                                                @endif
                                            </div>
                                            @if((Auth::user()->current_enrollments->first()->approved_at) || (now() > $enrollments_end_date) || ($course->max_enrollments_number == $course->students_enrollments_number))
                                            @elseif($courseEnrollment && $courseEnrollment->schedule_id != $course->id)
                                                <div class="text-white hover">
                                                    @lang('modules.courses.enrolled_already')
                                                </div>
                                            @elseif (!$courseEnrollment || ($courseEnrollment->final_gpa <= 1 && $courseEnrollment->final_gpa != null))
                                                <button class="hover" wire:click='enroll_course("{{ $course->course->id }}", "{{ $course->id }}")'>
                                                    <h4>@lang('forms.create')</h4>
                                                </button>
                                            @else
                                                <button class="hover btn btn-danger bg-danger" wire:click='delete_enroll_course("{{ $courseEnrollment->id }}")' wire:confirm='Are you sure?'>
                                                    <h4>@lang('forms.delete')</h4>
                                                </button>
                                            @endif
                                        </div>
                                        @unless ($loop->last)
                                            <hr>
                                        @endunless
                                    @endforeach
                                @endif
                            </td>
                        @endfor

                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</x-page>

@push('styles')
    <style>
       .schedule-table table thead tr {
            background: #212529;
;
        }

        .schedule-table table thead th {
            padding: 25px 25px;
            color: #fff;
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            position: relative;
            border: 0;
        }

        .schedule-table table thead th:before {
            content: "";
            width: 3px;
            height: 35px;
            background: rgba(255, 255, 255, 0.2);
            position: absolute;
            right: -1px;
            top: 50%;
            transform: translateY(-50%);
        }

        .schedule-table table thead th.last:before {
            content: none;
        }

        .schedule-table table tbody td {
            vertical-align: middle;
            border: 1px solid #e2edf8;
            font-weight: 500;
            padding: 30px;
            text-align: center;
        }

        .schedule-table table tbody td.day {
            font-size: 22px;
            font-weight: 600;
            background: #f0f1f3;
            border: 1px solid #e4e4e4;
            position: relative;
            transition: all 0.3s linear 0s;
            min-width: 140px;
        }

        .schedule-table table tbody div.active {
            position: relative;
            transition: all 0.3s linear 0s;
            min-width: 140px;
        }

        .schedule-table table tbody div.active h4 {
            font-weight: 700;
            color: #000;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .schedule-table table tbody div.active p {
            font-size: 14px;
            line-height: normal;
            margin-bottom: 0;
        }

        .schedule-table table tbody div.active span {
            font-size: 16px;
            line-height: normal;
            margin-bottom: 0;
            font-weight: 500;
        }

        .schedule-table table tbody td .hover h4 {
            font-weight: 700;
            font-size: 18px;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .schedule-table table tbody td .hover p {
            font-size: 16px;
            margin-bottom: 5px;
            color: #ffffff;
            line-height: normal;
        }

        .schedule-table table tbody td .hover span {
            color: #ffffff;
            font-weight: 600;
            font-size: 18px;
        }

        .schedule-table table tbody div.active::before {
            position: absolute;
            content: "";
            min-width: 100%;
            min-height: 100%;
            transform: scale(0);
            top: 0;
            left: 0;
            z-index: -1;
            border-radius: 0.25rem;
            transition: all 0.3s linear 0s;
        }

        .schedule-table table tbody td .hover {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 120%;
            transform: translate(-50%, -50%) scale(0.8);
            z-index: 99;
            background: #212529;
;
            border-radius: 0.25rem;
            padding: 25px 0;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s linear 0s;
        }

        .schedule-table table tbody div.active:hover .hover {
            transform: translate(-50%, -50%) scale(1);
            visibility: visible;
            opacity: 1;
            height: fit-content;
        }

        .schedule-table table tbody td.day:hover {
            background: #212529;
;
            color: #fff;
            border: 1px solid #212529;
;
        }

        @media screen and (max-width: 1199px) {
            .schedule-table {
                display: block;
                width: 100%;
                overflow-x: auto;
            }

            .schedule-table table thead th {
                padding: 25px 40px;
            }

            .schedule-table table tbody td {
                padding: 20px;
            }

            .schedule-table table tbody div.active h4 {
                font-size: 18px;
            }

            .schedule-table table tbody div.active p {
                font-size: 12px;
            }

            .schedule-table table tbody div.active span {
                font-size: 14px;
            }

    </style>
@endpush
