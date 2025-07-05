<x-page title="sidebar.courses.index" module="courses" show_create_button="true">

    <div class="card-body" style="overflow-x: scroll;">
        <div class="p-2 my-3 row">
            <div class="col-md-6">
                <input type="text" name="" id="" placeholder="{{ App::isLocale('ar') ? 'بحث...' : 'Search...' }}" class="form-control fs-5" wire:model.live='search'>
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
        </div>
        @if ($courses->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.courses.code')</th>
                        <th>@lang('modules.courses.name_en')</th>
                        <th>@lang('modules.courses.name_ar')</th>
                        <th>@lang('modules.courses.level')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <livewire:courses::course-list :course="$course" wire:key='{{ $course->id }}' :loop="$loop"/>
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
