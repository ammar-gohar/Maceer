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

        return view('courses::livewire.pages.all-enrollments', [
            'enrolls' => Enrollment::with(['course', 'grade', 'semester'])
                                    ->where('student_id', Auth::user()->id)
                                    ->orderBy('created_at')
                                    ->get()
                                    ->groupBy('semester.name'),
        ])->title(__('sidebar.courses.all-enrollments'));
    }
}
