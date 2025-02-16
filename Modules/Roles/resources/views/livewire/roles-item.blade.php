<tr class="align-middle">
    <td class="text-center">{{ $iteration }}</td>
    <td>{{ $role->translatedName }}</td>
    <td>{{ $role->name == 'Super Admin' ? '*' : $role->permissions->count() }}</td>
    <td>{{ $role->users->count() }}</td>
    <td class="text-center">
        <a wire:navigate href="{{ route('roles.show', $role->id) }}" class="btn btn-primary">
            @lang('general.show')
        </a>
        @unless ($role->name == 'Super Admin')
            <a wire:navigate href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
                @lang('general.edit')
            </a>
            <button class="btn btn-danger"
                wire:confirm.prompt='Type DELETE to delete this role\n|DELETE'
                wire:click='$parent.deleteRole()'
                >
                @lang('general.delete')
            </button>
        @endunless
    </td>
</tr>
