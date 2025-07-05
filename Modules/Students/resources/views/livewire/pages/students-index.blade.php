<x-page title="sidebar.students.index" module="students" show_create_button="true">

    <div class="card-body">
        {{-- FILTERS --}}
        <div class="p-2 my-3 row" style="font-size: 1rem;">
            <div class="col-md-3">
                <input type="text" name="search" id="search" wire:model.live='search' placeholder="{{ App::isLocale('ar') ? 'بحث...' : 'Search...' }}" class="form-control">
            </div>
            <div class="form-group row col-md-5 offset-3">
                <div class="col-md-9 d-flex">
                    <label for="sortBy" class="fw-bold me-2" style="white-space: nowrap; font-size:1rem;">@lang('general.sort_by'):</label>
                    <select id="sortBy" class="form-select form-control" wire:model.change='sortBy.0'>
                        <option value="name" {{ $sortBy[0] == 'name' ? 'selected' : '' }}>@lang('modules.students.name')</option>
                        <option value="credits" {{ $sortBy[0] == 'credits' ? 'selected' : '' }}>@lang('modules.students.credits')</option>
                        <option value="gpa" {{ $sortBy[0] == 'gpa' ? 'selected' : '' }}>@lang('modules.students.gpa')</option>
                        <option value="level" {{ $sortBy[0] == 'level' ? 'selected' : '' }}>@lang('modules.students.level')</option>
                    </select>
                </div>
                <div class="px-0 col-md-3">
                    <select id="sortByOptions" class="form-select form-control" wire:model.change='sortBy.1'>
                        <option value="asc" {{ $sortBy[1] == 'asc' ? 'selected' : '' }}>@lang('general.sort_by_options.asc')</option>
                        <option value="desc" {{ $sortBy[1] == 'desc' ? 'selected' : '' }}>@lang('general.sort_by_options.desc')</option>
                    </select>
                </div>
            </div>
            <div class="dropdown col-md-1">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="p-2 dropdown-menu" style="z-index: 999; min-width: 20rem;">
                    <div class="form-group">
                        <label for="levelFilter" class="mb-1 fw-bold">@lang('modules.students.level')</label>
                        <select id="levelFilter" class="form-select form-control" wire:model.change='levelFilter'>
                            <option value="all">{{ App::isLocale('ar') ? 'الجميع' : 'All' }}</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" wire:key='{{ $loop->iteration }}-levels'>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- /FILTERS --}}
        @if ($students->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.students.name')</th>
                        <th>@lang('modules.students.gender')</th>
                        <th>@lang('modules.students.level')</th>
                        <th>@lang('modules.students.credits')</th>
                        <th>@lang('modules.students.gpa')</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <livewire:students::student-list :student="$student" wire:key='{{ $student->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.students.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $students->links() }}
    </div>

</x-page>
