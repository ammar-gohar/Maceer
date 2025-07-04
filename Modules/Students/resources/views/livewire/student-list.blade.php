<x-modules-list :loop="$loop->iteration" module="students" :parameter="$student->national_id">
    <td>{{ $student->name }}</td>
    <td>{{ $student->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
    <td>{{ $student->level }}</td>
    <td>{{ $student->total_earned_credits }}</td>
    <td>{{ $student->gpa }}</td>
</x-modules-list>
