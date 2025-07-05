<x-modules-list :loop="$loop->iteration" module="professors" :parameter="$professor->national_id">
    <td>{{ $professor->name }}</td>
    <td>{{ $professor->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
</x-modules-list>
