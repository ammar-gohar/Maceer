<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Semesters\Models\Semester;

class StudentCourses extends Component
{

    public $semesterId;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if (!$this->semesterId && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        }
    }

    public function render()
    {
        dd(Auth::user()->student);

        return view('courses::livewire.pages.student-courses', [
            'enrolls' => Enrollment::with(['course', 'grade'])->where('student_id', Auth::user()->id)->where('semester_id', $this->semesterId)->get(),
        ])->title(__('sidebar.courses.student-show'));
    }
}
