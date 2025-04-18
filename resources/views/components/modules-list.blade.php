@props(['loop', 'module', 'parameter'])
<tr class="align-middle">
    <td class="text-center">{{ $loop }}.</td>
    {{ $slot }}
    <td style="white-space: nowrap;">
        @can($module . '.show')
            <a href="{{ route($module . '.show', $parameter) }}" class="btn btn-sm btn-secondary">
                <i class="fa-solid fa-eye"></i>
            </a>
        @endcan
        @can($module . '.edit')
            <a href="{{ route($module . '.edit', $parameter) }}" class="btn btn-sm btn-primary">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        @endcan
        @can($module . '.delete')
            @unless (isset($attributes['undeleteble']) && $attributes['undeleteble'])
                <button class="btn btn-sm btn-danger"
                    wire:confirm='Are you sure you want to delete this?'
                    wire:click='$parent.delete("{{ $parameter }}")'
                    >
                        <i class="fa-solid fa-trash-can"></i>
                </button>
            @endunless
        @endcan
    </td>
</tr>
