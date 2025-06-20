<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Semesters\Models\Semester;

class AllEnrollments extends Component
{

    public function render()
    {

        dd(Enrollment::with(['course', 'grade', 'semester'])
                                    ->where('student_id', Auth::user()->id)
                                    ->get()
                                    ->groupBy('semester_id'));

        return view('courses::livewire.pages.all-enrollments', [
            'enrolls' => Enrollment::with(['course', 'grade', 'semester'])
                                    ->where('student_id', Auth::user()->id)
                                    ->get()
                                    ->groupBy('semester_id'),
        ])->title(__('sidebar.courses.all-enrollments'));
    }
}
