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
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
    }

    public function render()
    {

        if(Auth::user()->hasPermissionTo('courses.enrollment'))
        {
            $scheduleIds = Enrollment::with(['course', 'schedule', 'course.level'])
                                ->where('semester_id', $this->semesterId)
                                ->where('student_id', Auth::id())
                                ->get()->pluck('schedule_id')->toArray();

            $courses = Schedule::with(['course', 'professor', 'course.level', 'hall'])
                                ->where('semester_id', $this->semesterId)
                                ->whereIn('id', $scheduleIds)
                                ->get()
                                ->groupBy('course.code');

        } else {
            $courses = Schedule::with(['course', 'professor', 'course.level', 'hall'])
                                ->withCount('current_enrollments')
                                ->where('semester_id', $this->semesterId)
                                ->get()
                                ->groupBy('course.code');

        }

        return view('courses::livewire.pages.scedule-list', [
            'courses' => $courses,
        ])->title(__('sidebar.courses.schedule-list'));

    }
}
