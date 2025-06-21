<x-modules-list :loop="$loop->iteration" module="moderators" :parameter="$moderator->national_id">
    <td>{{ $moderator->full_name }}</td>
    <td>{{ $moderator->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
</x-modules-list>
