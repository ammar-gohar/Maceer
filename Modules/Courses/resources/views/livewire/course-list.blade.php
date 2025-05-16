<x-modules-list :loop="$loop->iteration" module="courses" :parameter="$course->code">
    <td class="text-center">{{ $course->code }}</td>
    <td dir="ltr">{{ $course->name }}</td>
    <td>{{ $course->name_ar }}</td>
    <td>{{ $course->level->name }}</td>
</x-modules-list>
