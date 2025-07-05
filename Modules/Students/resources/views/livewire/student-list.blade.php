<x-modules-list :loop="$loop->iteration" module="students" :parameter="$student->national_id">
    <td>{{ $student->name }}</td>
    <td>{{ $student->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
    <td>{{ $student->level }}</td>
    <td>{{ $student->total_earned_credits }}</td>
    <td>{{ $student->gpa }}</td>
    <td>
        <a href="{{ route('docs.create', ['studentId' => $student->national_id]) }}" class="btn btn-sm btn-dark">
            {{ App::isLocale('ar') ? 'طباعة وثيقة' : 'Print doc' }}
        </a>
    </td>
</x-modules-list>
