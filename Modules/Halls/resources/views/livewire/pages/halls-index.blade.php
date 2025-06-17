<x-page title="sidebar.halls.index" module="halls" ::show_delete_button="true">

    <div class="card-body" style="overflow-x: scroll;">
        <div class="p-2 my-3 row">
            <div class="col-md-6">
                <input type="text" name="search" wire:model.live='search' id="search" placeholder="{{ App::isLocale('ar') ? 'بحث...' : 'Search...' }}" class="form-control fs-5">
            </div>
            <div class="dropdown col-md-1 offset-5">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="p-2 dropdown-menu" style="z-index: 999;">
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <select id="trashFilter" class="form-select form-control" wire:model.change='trashFilter' style="width: fit-content;">
                            <option value="undeleted" {{ $trashFilter == 'undeleted' ? 'selected' : '' }}>@lang('filters.undeleted')</option>
                            <option value="all" {{ $trashFilter == 'all' ? 'selected' : '' }}>@lang('filters.all')</option>
                            <option value="trashed" {{ $trashFilter == 'trashed' ? 'selected' : '' }}>@lang('filters.trashed')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @if ($halls->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.halls.name')</th>
                        <th>@lang('modules.halls.address')</th>
                        <th>@lang('modules.halls.type')</th>
                        <th>@lang('modules.halls.status.title')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($halls as $hall)
                        <livewire:halls::halls-list :hall="$hall" wire:key='{{ $hall->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.halls.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $halls->links() }}
    </div>

</x-page>
