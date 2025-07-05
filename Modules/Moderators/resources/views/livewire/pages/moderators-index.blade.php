<x-page title="sidebar.moderators.index" module="moderators" show_create_button="true">

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
                        <option value="name">@lang('modules.moderators.name')</option>
                    </select>
                </div>
                <div class="px-0 col-md-3">
                    <select id="sortByOptions" class="form-select form-control" wire:model.change='sortBy.1'>
                        <option value="asc">@lang('general.sort_by_options.asc')</option>
                        <option value="desc">@lang('general.sort_by_options.desc')</option>
                    </select>
                </div>
            </div>
        </div>
        {{-- /FILTERS --}}
        @if ($moderators->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('forms.name')</th>
                        <th>@lang('forms.gender')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moderators as $moderator)
                        <livewire:moderators::moderator-list :moderator="$moderator" wire:key='{{ $moderator->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.moderators.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $moderators->links() }}
    </div>

</x-page>
