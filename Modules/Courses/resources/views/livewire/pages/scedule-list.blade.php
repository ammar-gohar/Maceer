<x-page title="sidebar.courses.schedule-list" module="courses">

    @if (!$semesterId)
        <div class="px-4 card-body">
            <div class="alert alert-warning">
                @lang('general.unavailable_page')
            </div>
        </div>
    @else
        <div class="card-body" style="overflow-x: scroll;">
            @if ($courses->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>@lang('modules.courses.code')</th>
                            <th>@lang('modules.courses.name')</th>
                            <th>@lang('modules.courses.level')</th>
                            <th>@lang('modules.courses.schedule')</th>
                            @if(Auth::user()->hasPermissionTo('courses.enrollment') && !Auth::user()->hasRole('Super Admin'))
                                <th>@lang('modules.halls.hall')</th>
                                <th></th>
                            @else
                                <th>@lang('modules.courses.enrollments_count')</th>
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $code => $course)
                            <tr class="align-middle" wire:key='course{{ $loop->iteration }}'>
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td class="text-center">{{ $code }}</td>
                                <td dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">{{ $course->first()->course->translated_name }}</td>
                                <td>{{ $course->first()->course->level?->name }}</td>
                                <td>
                                    @foreach ($course as $schedule)
                                        {{ __("general.$schedule->day") }}: {{ $schedule->start_period }} - {{ $schedule->start_period + 1 }}
                                        @unless ($loop->last)
                                            <hr />
                                        @endunless
                                    @endforeach
                                </td>
                                @if(Auth::user()->hasPermissionTo('courses.enrollment') && !Auth::user()->hasRole('Super Admin'))
                                    <td>
                                        @foreach ($course as $schedule)
                                            {{ $schedule->hall->building }} - {{ $schedule->hall->floor }}
                                            @unless ($loop->last)
                                                <hr />
                                            @endunless
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($course as $schedule)
                                            <a href="{{ route('courses.library', ['code' => $schedule->course->code]) }}" class="btn btn-sm btn-warning" title="{{ App::isLocale('ar') ? 'المكتبة' : 'Library' }}">
                                                <i class="bi bi-folder-fill"></i>
                                            </a>
                                        @endforeach
                                    </td>
                                @else
                                    <td style="white-space: nowrap;">
                                        @foreach ($course as $schedule)
                                            {{ $schedule->current_approved_enrollments_count }}
                                            @unless ($loop->last)
                                                <hr />
                                            @endunless
                                        @endforeach
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @foreach ($course as $schedule)
                                            <a target="_blank" href="{{ route('reports.coruses.students', ['scheduleId' => $schedule->id]) }}" class="btn btn-sm btn-dark">
                                                <i class="fa-solid fa-print"></i> {{ App::isLocale('ar') ? 'قائمة الطلاب' : 'Students list' }}
                                            </a>
                                            @unless ($loop->last)
                                                <hr />
                                            @endunless
                                        @endforeach
                                    </td>
                                @endcan
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
        <!-- /.card-body -->
    @endif

</x-page>
