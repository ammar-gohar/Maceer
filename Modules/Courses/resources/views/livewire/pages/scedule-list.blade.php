<x-page title="sidebar.courses.schedule-list" module="courses">

    <div class="card-body" style="overflow-x: scroll;">
        {{-- <div class="p-2 my-3 row">
            <div class="col-md-6">
                <input type="text" name="" id="" placeholder="{{ App::isLocale('ar') ? 'بحث...' : 'Search...' }}" class="form-control fs-5">
            </div>
            <div class="dropdown col-md-1 offset-5">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="p-2 dropdown-menu" style="z-index: 999;">
                    <div class="form-group">
                        <label for="levelFilter">@lang('modules.students.level')</label>
                        <select id="levelFilter" class="form-select form-control">
                            <option value="">All</option>
                            <option value="">Freshman</option>
                            <option value="">Sophomore</option>
                            <option value="">Junior</option>
                            <option value="">Senior - 1</option>
                            <option value="">Senior - 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="trashFilter" class="form-select form-control" wire:model.change='trashFilter'>
                            <option value="undeleted" {{ $trashFilter == 'undeleted' ? 'selected' : '' }}>@lang('filters.undeleted')</option>
                            <option value="all" {{ $trashFilter == 'all' ? 'selected' : '' }}>@lang('filters.all')</option>
                            <option value="trashed" {{ $trashFilter == 'trashed' ? 'selected' : '' }}>@lang('filters.trashed')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> --}}
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
                            <td style="white-space: nowrap;">
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
