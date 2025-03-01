<div class="px-4 mx-auto my-4 card card-secondary card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header d-flex">
        <div class="my-auto card-title">@lang($title)</div>
        @if ($showCreateButton)
            <a wire:navigate href="{{ route($module . '.create') }}" class="float-end btn btn-primary">@lang('sidebar.' . $module . '.create')</a>
        @endif
        @if ($showIndexButton)
            <a wire:navigate href="{{ route($module . '.index') }}" class="float-end btn btn-primary">@lang('sidebar.' . $module . '.index')</a>
        @endif
        @if ($showEditButton)
            <a wire:navigate href="{{ route($module . '.edit') }}" class="float-end btn btn-warning">@lang('sidebar.' . $module . '.edit')</a>
        @endif
    </div>
    <!--end::Header-->

    {{ $slot }}

</div>
