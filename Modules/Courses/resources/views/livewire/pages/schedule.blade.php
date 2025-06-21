<x-page title="sidebar.courses.schedule" module="courses">
    <div class="container card-body" style="overflow-x: scroll;">
        <div class="row">
          <div class="col-md-12">
            <div class="schedule-table">
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
                            <td wire:key='saturday-{{ $i }}'>
                                @if (isset($schedules['saturday']))
                                    @foreach ($schedules['saturday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='saturday-{{ $i }}-{{ $loop->iteration }}'>
                                            <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                            <p>{{ $course->professor->full_name }}</p>
                                            <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                            <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                            <button class="hover" wire:click='show_modal(["saturday", {{ $i }}, "{{ $course->id }}"])'>
                                                <h4>@lang('forms.edit')</h4>
                                            </button>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="active" style="width:fit-content;">
                                    <button type="button" class="btn btn-light" wire:click='show_modal(["saturday", {{ $i }}])'>@lang('forms.create')</button>
                                </div>
                            </td>
                        @endfor

                    </tr>
                    <tr>
                        <td class="day">@lang('general.sunday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='sunday-{{ $i }}'>
                                @if (isset($schedules['sunday']))
                                    @foreach ($schedules['sunday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='sunday-{{ $i }}-{{ $loop->iteration }}'>
                                            <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                            <p>{{ $course->professor->full_name }}</p>
                                            <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                            <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                            <button class="hover" wire:click='show_modal(["sunday", {{ $i }}, "{{ $course->id }}"])'>
                                                <h4>@lang('forms.edit')</h4>
                                            </button>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="active" style="width:fit-content;">
                                    <button type="button" class="btn btn-light" wire:click='show_modal(["sunday", {{ $i }}])'>@lang('forms.create')</button>
                                </div>
                            </td>
                        @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.monday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                                <td wire:key='monday-{{ $i }}'>
                                    @if (isset($schedules['monday']))
                                        @foreach ($schedules['monday']->where('start_period', $i) as $course)
                                            <div class="active" style="width:fit-content;" wire:key='monday-{{ $i }}-{{ $loop->iteration }}'>
                                                <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                                <p>{{ $course->professor->full_name }}</p>
                                                <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                                <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                                <button class="hover" wire:click='show_modal(["monday", {{ $i }}, "{{ $course->id }}"])'>
                                                    <h4>@lang('forms.edit')</h4>
                                                </button>
                                            </div>
                                            <hr>
                                        @endforeach
                                    @endif
                                    <div class="active" style="width:fit-content;">
                                        <button type="button" class="btn btn-light" wire:click='show_modal(["monday", {{ $i }}])'>@lang('forms.create')</button>
                                    </div>
                                </td>
                            @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.tuesday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='tuesday-{{ $i }}'>
                                @if (isset($schedules['tuesday']))
                                    @foreach ($schedules['tuesday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='tuesday-{{ $i }}-{{ $loop->iteration }}'>
                                            <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                            <p>{{ $course->professor->full_name }}</p>
                                            <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                            <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                            <button class="hover" wire:click='show_modal(["tuesday", {{ $i }}, "{{ $course->id }}"])'>
                                                <h4>@lang('forms.edit')</h4>
                                            </button>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="active" style="width:fit-content;">
                                    <button type="button" class="btn btn-light" wire:click='show_modal(["tuesday", {{ $i }}])'>@lang('forms.create')</button>
                                </div>
                            </td>
                        @endfor

                    </tr>

                    <tr>
                        <td class="day">@lang('general.wednesday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='wednesday-{{ $i }}'>
                                @if (isset($schedules['wednesday']))
                                    @foreach ($schedules['wednesday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='wednesday-{{ $i }}-{{ $loop->iteration }}'>
                                            <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                            <p>{{ $course->professor->full_name }}</p>
                                            <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                            <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                            <button class="hover" wire:click='show_modal(["wednesday", {{ $i }}, "{{ $course->id }}"])'>
                                                <h4>@lang('forms.edit')</h4>
                                            </button>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="active" style="width:fit-content;">
                                    <button type="button" class="btn btn-light" wire:click='show_modal(["wednesday", {{ $i }}])'>@lang('forms.create')</button>
                                </div>
                            </td>
                        @endfor

                    </tr>

                    <tr>

                        <td class="day">@lang('general.thursday')</td>

                        @for($i = 1; $i < 10; $i += 2)
                            <td wire:key='thursday-{{ $i }}'>
                                @if (isset($schedules['thursday']))
                                    @foreach ($schedules['thursday']->where('start_period', $i) as $course)
                                        <div class="active" style="width:fit-content;" wire:key='thursday-{{ $i }}-{{ $loop->iteration }}'>
                                            <h4>{{ App::isLocale('ar') ? $course->course->name_ar : $course->course->name }} ({{ $course->course->level->name }})</h4>
                                            <p>{{ $course->professor->full_name }}</p>
                                            <span>{{ $course->hall->name . ' - ' .  $course->hall->building . ' - ' . $course->hall->floor }}</span>
                                            <span>{{ App::isLocale('ar') ?  'المقاعد:' : 'Seats:' }} ({{ $course->max_enrollments_number }})</span>
                                            <button class="hover" wire:click='show_modal(["thursday", {{ $i }}, "{{ $course->id }}"])'>
                                                <h4>@lang('forms.edit')</h4>
                                            </button>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="active" style="width:fit-content;">
                                    <button type="button" class="btn btn-light" wire:click='show_modal(["thursday", {{ $i }}])'>@lang('forms.create')</button>
                                </div>
                            </td>
                        @endfor

                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @if ($showModal)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">@lang('modules.courses.add_schedule', ['day' => __('general.'.$showModal[0]), 'period' => "$showModal[1] - " . $showModal[1]+1 ])</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <form wire:submit='add_schedule()' class="px-4 row form-group">
                        <div class="px-4 modal-body">
                            <div class="mb-3">
                                <label for="course">@lang('modules.courses.course'):</label>
                                <select wire:model='course' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر مقرر' : 'Choose a course' }}</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ $course->id == $course ? 'selected' : '' }}>{{ App::isLocale('ar') ? $course->name_ar : $course->name }} ({{ $course->level->name }})</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.halls.hall'):</label>
                                <select wire:model='hall' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر قاعة' : 'Choose a hall' }}</option>
                                    @foreach ($halls as $hall)
                                        <option value="{{ $hall->id }}" {{ $hall->id == $hall ? 'selected' : '' }}>{{ $hall->name }}</option>
                                    @endforeach
                                </select>
                                @error('hall')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.professors.professor'):</label>
                                <select wire:model='professor' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر معلم' : 'Choose a professor' }}</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}" {{ $professor->id == $professor ? 'selected' : '' }}>{{ $professor->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('professor')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.courses.enrollments_number'):</label>
                                <input type="number" class="mt-1 col-12 form-control" mix="0" wire:model='max_enrollments_number'>
                                @error('max_enrollments_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <h4>
                                    @lang('modules.courses.students_enrolled', ['count' => $students_enrolled])
                                </h4>
                            </div>
                        </div>
                        <div class="px-3 modal-footer">
                            <button type="submit" class="btn btn-primary">{{ count($showModal) <= 2 ? __('forms.create') : __('forms.edit') }}</button>
                            <button type="button" class="btn btn-secondary" wire:click='close_modal()'>@lang('forms.close')</button>
                            @if (count($showModal) > 2)
                                <button type="button" class="btn btn-danger" wire:click='delete_schedule("{{ $showModal[5] }}")'>@lang('forms.delete')</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
      @endif
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
