<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Reports\Models\Receipt;
use Modules\Semesters\Models\Semester;

class StudentCourses extends Component
{

    public $semesterId;
    public $enrollmentEnd;

    public function mount()
    {
        $semester = Semester::where('is_current', 1)->first();

        if (!$semester && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        } else if($semester) {
            $this->semesterId = $semester->id;
            $this->enrollmentEnd = $semester->enrollments_end_date;
        }

    }

    public function render()
    {
        return view('courses::livewire.pages.student-courses', [
            'enrolls' => Enrollment::with(['course', 'grade'])->where('student_id', Auth::user()->id)->where('semester_id', $this->semesterId)->get(),
            'receipt' => Receipt::with(['student'])->where('student_id', Auth::id())->where('semester_id', $this->semesterId)->first(),
        ])->title(__('sidebar.courses.student-show'));
    }
}
