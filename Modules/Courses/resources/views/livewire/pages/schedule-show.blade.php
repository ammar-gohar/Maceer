<x-page title="sidebar.courses.schedule" module="courses">
    <div class="container card-body" style="overflow-x: scroll;">
        <div class="row">
          <div class="col-md-12">
            <div class="schedule-table">
              <table class="bg-white">
                <thead>
                  <tr class="bg-dark">
                    <th class="last">@lang('sidebar.courses.title')</th>
                    <th dir="ltr">
                        1 - 2 <br>
                        <span style="font-size: 15px;">09:00 - 10:50 am</span>
                    </th>
                    <th dir="ltr">
                        3 - 4 <br>
                        <span style="font-size: 15px;">10:50 - 12:40 pm</span>
                    </th>
                    <th dir="ltr">
                        5 - 6 <br>
                        <span style="font-size: 15px;">01:00 - 02:50 pm</span>
                    </th>
                    <th dir="ltr">
                        7 - 8 <br>
                        <span style="font-size: 15px;">02:50 - 03:40 am</span>
                    </th>
                    <th dir="ltr">
                        9- 1 0 <br>
                        <span style="font-size: 15px;">03:40 - 04:30 pm</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="day">@lang('general.saturday')</td>

                        <td>

                        </td>

                        <td>
                        </td>

                        <td>
                        </td>

                        <td>
                        </td>

                        <td>
                        </td>

                    </tr>
                  <tr>
                    <td class="day">@lang('general.sunday')</td>

                    <td>
                        <div class="active">
                            <h4>Weight Loss</h4>
                            <p>10 am - 11 am</p>
                            <div class="hover">
                                <h4>Weight Loss</h4>
                                <p>10 am - 11 am</p>
                                <span>Wayne Ponce</span>
                            </div>
                        </div>

                        <hr>

                        <div class="active">
                            <h4>Weight Loss</h4>
                            <p>10 am - 11 am</p>
                            <div class="hover">
                                <h4>Weight Loss</h4>
                                <p>10 am - 11 am</p>
                                <span>Wayne Ponce</span>
                            </div>
                        </div>

                        <hr>

                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>
                  </tr>

                  <tr>
                    <td class="day">@lang('general.monday')</td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>
                  </tr>

                  <tr>
                    <td class="day">@lang('general.tuesday')</td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>
                  </tr>

                  <tr>
                    <td class="day">@lang('wednesday')</td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>
                  </tr>

                  <tr>
                    <td class="day">@lang('general.thursday')</td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>

                    <td>
                    </td>
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
                        <h5 class="modal-title">@lang('modules.courses.add_schedule') {{ $showModal[0] . ' ' . $showModal[1] }}</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <form wire:submit='add_schedule()' class="row form-group">
                        <div class="px-4 modal-body">
                            <div class="mb-3">
                                <label for="course">@lang('modules.courses.course')</label>
                                <select wire:model='courseId' class="col-12 form-select">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ $course->id == $courseId ? 'selected' : '' }}>{{ App::isLocale('ar') ? $course->name_ar : $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.halls.hall')</label>
                                <select wire:model='hallId' class="col-12 form-select">
                                    @foreach ($halls as $hall)
                                        <option value="{{ $hall->id }}" {{ $hall->id == $hallId ? 'selected' : '' }}>{{ $hall->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.courses.course')</label>
                                <select wire:model='professorId' class="col-12 form-select">
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}" {{ $professor->id == $professorId ? 'selected' : '' }}>{{ $professor->FullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="px-3 modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click='close_modal()'>Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
            min-width: 165px;
        }

        .schedule-table table tbody div.active {
            position: relative;
            transition: all 0.3s linear 0s;
            min-width: 165px;
        }

        .schedule-table table tbody div.active h4 {
            font-weight: 700;
            color: #000;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .schedule-table table tbody div.active p {
            font-size: 16px;
            line-height: normal;
            margin-bottom: 0;
        }

        .schedule-table table tbody td .hover h4 {
            font-weight: 700;
            font-size: 20px;
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
            height: 120%;
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
                font-size: 15px;
            }

    </style>
@endpush
