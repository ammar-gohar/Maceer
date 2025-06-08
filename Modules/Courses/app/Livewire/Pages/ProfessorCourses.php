<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Schedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Semesters\Models\Semester;

class ProfessorCourses extends Component
{

    public $semesterId;

    public $modal = [];

    public $shownScheduleId = '';

    public $shownColumns = [];

    public function show_modal($courseId, $courseName)
    {

        $schedules = Schedule::with(['course'])
                            ->where('semester_id', $this->semesterId)
                            ->where('course_id', $courseId)
                            ->get();

        $this->shownScheduleId = $schedules->first()->id;

        $enrollments = Enrollment::with(['course', 'student'])
                                ->where('semester_id', $this->semesterId)
                                ->where('schedule_id', $this->shownScheduleId)
                                ->where('course_id', $courseId)
                                ->get()
                                ->sortBy(['student.first_name', 'student.last_name']);

        $this->shownColumns = explode('-', Enrollment::with(['course', 'student'])
                                                    ->where('semester_id', $this->semesterId)
                                                    ->where('course_id', $courseId)
                                                    ->first()?->shown_columns) ;

        $this->modal = [
            'enrollments' => $enrollments,
            'schedules' => $schedules,
            'courseName' => $courseName,
            'courseId' => $courseId,
        ];
    }

    public function updated($prop, $val)
    {

        if($prop === 'shownColumns.0' || $prop === 'shownColumns.1' || $prop === 'shownColumns.2' || $prop === 'shownColumns.3' || $prop === 'shownColumns.4') {
            Enrollment::with(['course', 'student'])
                                    ->where('semester_id', $this->semesterId)
                                    ->where('course_id', $this->modal['courseId'])
                                    ->update([
                                        'shown_columns' => implode('-', $this->shownColumns)
                                    ]);
            notyf()->success(App::isLocale('ar') ? 'تم إعلان الدرجات' : 'Marks are published');
        }

        if($prop === 'shownScheduleId'){

            $enrollments = Enrollment::with(['course', 'student'])
                                    ->where('semester_id', $this->semesterId)
                                    ->where('schedule_id', $this->shownScheduleId)
                                    ->where('course_id', $this->modal['courseId'])
                                    ->get()
                                    ->sortBy(['student.first_name', 'student.last_name']);

            $this->modal['enrollments'] = $enrollments;
        }
    }

    public function close_modal()
    {
        $this->reset('shownScheduleId', 'modal');
    }

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
    }

    public function render()
    {

        return view('courses::livewire.pages.professor-courses', [
            'courses' => Course::with(['schedules', 'enrollments'])
                                    ->withCount('current_semester_enrollments')
                                    ->has('current_semester_schedule')
                                    // ->whereHas('current_semester_schedule', fn($q) => $q
                                    //     ->where('professor_id', Auth::id())
                                    // )
                                    ->get(),
        ])->title(__('sidebar.courses.professor-show'));
    }
}
