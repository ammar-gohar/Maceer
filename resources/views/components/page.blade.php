@props([
    'show_create_button' => false,
    'show_edit_button' => false,
    'show_delete_button' => false,
    'show_index_button' => false,
    'module' => '',
    'title' => '',
    'semester' => true,
])

<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang($title)</div>
        @if ($semester)
            <div class="col-md-6">
                @if ($show_create_button)
                    @can("$module.create")
                        <a href="{{ route($module . '.create') }}" class="mb-2 float-end btn btn-dark me-2"><i class="mx-1 fa-solid fa-plus"></i> @lang('modules.' . $module . '.create')</a>
                    @endcan
                @endif
                @if ($show_edit_button)
                    @can("$module.edit")
                        <a href="{{ route($module . '.edit', $show_edit_button) }}" class="mb-2 float-end btn btn-dark me-2"><i class="mx-1 fa-solid fa-pen-to-square"></i> @lang('modules.' . $module . '.edit')</a>
                    @endcan
                @endif
                @if ($show_index_button)
                    @can("$module.index")
                        <a href="{{ route($module . '.index') }}" class="mb-2 float-end btn btn-secondary me-2"><i class="mx-1 fa-regular fa-rectangle-list"></i> @lang('modules.' . $module . '.index')</a>
                    @endcan
                @endif
                @if ($show_delete_button)
                    @unless (isset($attributes['undeleteble']) && $attributes['undeleteble'])
                        @can("$module.delete")
                            <button class="mb-2 float-end btn btn-danger me-2"
                                wire:confirm='Are you sure you want to delete this?'
                                wire:click='delete()'
                                >
                                    <i class="mx-1 fa-solid fa-trash-can"></i>  @lang('modules.' . $module . '.delete')
                            </button>
                        @endcan
                    @endunless
                @endif
            </div>
        @endif
    </div>
    <!--end::Header-->

    @unless ($semester)
        <div class="px-4 card-body">
            <div class="alert alert-warning">
                @lang('general.unavailable_page')
            </div>
        </div>
    @else
        {{ $slot }}
    @endunless


</div>
