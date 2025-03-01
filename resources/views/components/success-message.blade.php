@props(['status', 'module', 'operation'])
@if ($status)
    <div class="my-3 alert alert-success" role="alert">
        @lang('modules.' . $module . '.success.' . $operation)
    </div>
@endif
