<x-page title="sidebar.courses.schedule-list" module="courses">

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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $name => $course)
                        <tr class="align-middle" wire:key='course{{ $loop->iteration }}'>
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td class="text-center">{{ $course->course->code }}</td>
                            <td dir="ltr">{{ $course->course->translated_name }}</td>
                            <td>{{ $course->course->level->name }}</td>
                            <td>{{ $course->level->name }}</td>
                            <td>{{ $course->current_semester_schedule }}</td>
                            <td>
                                <a href="{{ route('courses.library', ['code' => $course->code]) }}" class="btn btn-sm btn-warning" title="{{ App::isLocale('ar') ? 'المكتبة' : 'Library' }}">
                                    <i class="bi bi-folder-fill"></i>
                                </a>
                            </td>
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
    <div class="clearfix card-footer">
        {{ $courses->links() }}
    </div>

</x-page>
