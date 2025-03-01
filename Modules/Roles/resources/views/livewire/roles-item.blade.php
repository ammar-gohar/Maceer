<x-modules-list :loop="$iteration" module="roles" :parameter="$role->id" :undeleteble="$role->undeleteble" >
    <td>{{ $role->translatedName }}</td>
    <td>{{ $role->name == 'Super Admin' ? '*' : $role->permissions->count() }}</td>
    <td>{{ $role->users->count() }}</td>
</x-modules-list>
