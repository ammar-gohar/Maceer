<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\CourseRequest;
use Modules\Semesters\Models\Semester;

class CourseRequests extends Component
{

    public $courses_to_enroll = [];
    public $semesterId;
    public $coursesIds;
    public $request_end;
    public $request_start;

    public function mount()
    {

        $semester = Semester::where('is_current', 1)->first();

        if (!$semester && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        }

        if(!Auth::user()->hasPermissionTo('courses.enrollment')) {
            return $this->redirectRoute('courses.requests-stats');
        }

        $this->semesterId = $semester?->id;
        $this->request_start = $semester?->requests_start_date;
        $this->request_end = $semester?->enrollments_start_date;

        $this->courses_to_enroll = CourseRequest::where('student_id', Auth::user()->student->id)->pluck('course_id')->toArray();
    }


    public function add_request(string $id)
    {
        if(!in_array($id, $this->coursesIds)){
            return notyf()->error(App::isLocale('ar') ? 'خطأ' : 'Error');
        } else if (in_array($id, $this->courses_to_enroll)) {
            return notyf()->error(__('modules.courses.already_enrolled'));
        } else if (count($this->courses_to_enroll) >= 5){
            return notyf()->error(App::isLocale('ar') ? 'بلغت حد المقررات المسموح الطلب بها': 'You\'ve reached the maximum number of requests');
        }
        $this->courses_to_enroll[] = $id;
        return notyf()->success(__('modules.courses.enrollment_success'));
    }

    public function remove_request($id)
    {
        $this->courses_to_enroll = array_diff($this->courses_to_enroll, [$id]);
        return notyf()->success(__('modules.courses.enrollment_deleted'));
    }

    public function save_requests()
    {
        Auth::user()->student->requests()->syncWithPivotValues($this->courses_to_enroll, ['semester_id' => $this->semesterId]);
        return notyf()->success(__('modules.courses.success.send_requests'));
    }

    public function render()
    {

        $query = Course::query()->with(['level', 'prerequests', 'prerequests.enrollments', 'enrollments'])
        ->whereDoesntHave('enrollments', fn($q) => $q
            ->where('student_id', Auth::user()->id)
            ->where('final_gpa', '>=', 1.00)
        )
        ->whereHas('level', fn($q) => $q
            ->where('number', '<=', Auth::user()->student->level->number)
        )
        ->where(fn($q) => $q
            ->whereDoesntHave('prerequests')
            ->orWhereHas('prerequests', fn($q) => $q
                ->whereHas('enrollments', fn($q) => $q
                    ->where('student_id', Auth::user()->id)
                    ->where('final_gpa', '>=', 1.00)
                )
            )
        )->orderBy('code', 'asc');

        $this->coursesIds = $query->pluck('id')->toArray();


        return view('courses::livewire.pages.course-requests', [
            'courses' => $query->get(),
        ])->title(__('sidebar.courses.requests'));
    }
}
