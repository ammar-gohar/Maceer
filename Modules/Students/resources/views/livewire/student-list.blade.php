<x-modules-list :loop="$loop->iteration" module="students" :parameter="$student->national_id">
    <td>{{ $student->fullName() }}</td>
    <td>{{ $student->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
    <td>{{ $student->student->level->name }}</td>
    <td>{{ $student->student->total_earned_credits }}</td>
    <td>{{ $student->student->gpa }}</td>
</x-modules-list>
