<x-modules-list :loop="$loop->iteration" module="halls" :parameter="$hall->id">
    <td>{{ $hall->name }}</td>
    <td>{{ $hall->building }} - {{ $hall->floor }}</td>
    <td>@lang('modules.halls.types.'.$hall->type)</td>
    <td>@lang('modules.halls.status.'.$hall->status)</td>
</x-modules-list>
