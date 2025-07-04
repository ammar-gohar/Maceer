<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Courses\Models\Schedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Semesters\Models\Semester;

class SceduleList extends Component
{

    public $semesterId;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first();
    }

    public function render()
    {

        if(Auth::user()->hasPermissionTo('courses.enrollment'))
        {
            $courses = Enrollment::with(['course', 'schedule', 'course.level'])->where('semester_id', $this->semesterId)->where('student_id', Auth::id())->get();
        } else {
            $courses = Schedule::with(['course', 'professor', 'course.level', 'hall', 'enrollments', 'enrollments.student'])->where('semester_id', $this->semesterId)->where('student_id', Auth::id())->get()->groupBy('course.translated_name');
        }

        return view('courses::livewire.pages.scedule-list', [
            'courses' => $courses,
        ]);
    }
}
