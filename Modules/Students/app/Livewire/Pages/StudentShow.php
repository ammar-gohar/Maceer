<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;

class StudentShow extends Component
{

    private $id;

    public function mount($national_id)
    {
        $this->id = $national_id;
    }

    public function render()
    {
        return view('students::livewire.pages.student-show', [
            'student' => User::with(['student'])->where('national_id', $this->id)->firstOrFail(),
            'enrolls' => Enrollment::with(['course', 'semester', 'course.level'])->whereHas('student', fn($q) => $q->where('national_id', $this->id))->get()->groupBy('semester.name')
        ]);
    }
}
