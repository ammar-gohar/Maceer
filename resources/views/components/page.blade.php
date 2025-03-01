<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6">@lang($title)</div>
        <div class="col-md-6">
            @if ($showCreateButton)
                <a wire:navigate href="{{ route($module . '.create') }}" class="mb-2 float-end btn btn-primary me-2">@lang('modules.' . $module . '.create')</a>
            @endif
            @if ($showIndexButton)
                <a wire:navigate href="{{ route($module . '.index') }}" class="mb-2 float-end btn btn-primary me-2">@lang('modules.' . $module . '.index')</a>
            @endif
            @if ($showEditButton)
                <a wire:navigate href="{{ route($module . '.edit', $showEditButton) }}" class="mb-2 float-end btn btn-warning me-2">@lang('modules.' . $module . '.edit')</a>
            @endif
        </div>
    </div>
    <!--end::Header-->

    {{ $slot }}

</div>
