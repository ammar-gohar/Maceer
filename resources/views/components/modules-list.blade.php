@props(['loop', 'module', 'parameter'])
<tr class="align-middle">
    <td class="text-center">{{ $loop }}.</td>
    {{ $slot }}
    <td>
        @can($module . '.show')
            <a wire:navigate href="{{ route($module . '.show', $parameter) }}" class="btn btn-sm btn-primary">
                @lang('general.show')
            </a>
        @endcan
        @can($module . '.edit')
            <a wire:navigate href="{{ route($module . '.edit', $parameter) }}" class="btn btn-sm btn-warning">
                @lang('general.edit')
            </a>
        @endcan
        @can($module . '.delete')
            @unless (isset($attributes['undeleteble']) && $attributes['undeleteble'])
                <button class="btn btn-sm btn-danger"
                    wire:confirm.prompt='Type DELETE to delete this student\n|DELETE'
                    wire:click='$parent.delete_student({{ $parameter }})'
                    >
                        @lang('general.delete')
                </button>
            @endunless
        @endcan
    </td>
</tr>
