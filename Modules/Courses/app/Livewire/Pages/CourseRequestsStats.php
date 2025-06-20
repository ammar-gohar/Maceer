<?php

namespace Modules\Courses\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\CourseRequest;
use Modules\Courses\Models\Schedule;
use Modules\Halls\Models\Hall;
use Modules\Semesters\Models\Semester;

class CourseRequestsStats extends Component
{

    public $semesterId;
    public $showModal = false;
    public $hall = '';
    public $professor = '';
    public $period = '';
    public $day = '';
    public $course;
    public $max_enrollments_number = 0;
    public $courseName;
    public $courseCode;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if (!$this->semesterId && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        }
    }

    public function show_modal($id)
    {
        $this->reset('course', 'hall', 'professor', 'day', 'period');
        $course = Course::find($id);
        $this->showModal = true;
        $this->courseCode = $course->code;
        $this->courseName = App::isLocale('ar') ? $course->name_ar : $course->name;
        $this->course = $id;
    }

    public function close_modal()
    {
        $this->showModal = '';
    }
    public function add_schedule()
    {
        $validatedData = $this->validate([
            'day' => 'bail|required|in:saturday,sunday,monday,tuesday,wednesday,thursday',
            'period' => 'bail|required|in:1,3,5,7,9',
            'course' => 'bail|required|exists:courses,id',
            'hall' => 'bail|required|exists:halls,id',
            'professor' => 'bail|required|exists:users,id',
            'max_enrollments_number' => 'bail|required|min:0',
        ]);
        $data = [
            'course_id' => $validatedData['course'],
            'hall_id' => $validatedData['hall'],
            'professor_id' => $validatedData['professor'],
            'semester_id' => $this->semesterId,
            'day' => $validatedData['day'],
            'start_period' => $validatedData['period'],
            'max_enrollments_number' => $validatedData['max_enrollments_number'],
        ];
        Schedule::create($data);
        notyf()->success(__('modules.courses.schedule_success_add'));
        $this->reset('course', 'hall', 'period', 'day', 'professor');
        $this->showModal = false;
    }

    public function render()
    {

        $reqs = CourseRequest::with(['course'])->select(
            'course_id',
            DB::raw('COUNT(*) as total_requests'),
            DB::raw('SUM(CASE WHEN (180 - students.total_earned_credits <= 21 AND students.gpa > 3.0)
                              OR (180 - students.total_earned_credits <= 18 AND students.gpa > 2.0)
                              THEN 1 ELSE 0 END) as graduating_students_requests'),
            DB::raw('SUM(CASE WHEN NOT ((180 - students.total_earned_credits <= 21 AND students.gpa > 3.0)
                                       OR (180 - students.total_earned_credits <= 18 AND students.gpa > 2.0))
                              THEN 1 ELSE 0 END) as other_requests')
        )
        ->leftJoin('students', 'course_requests.student_id', '=', 'students.id')
        ->groupBy('course_id')
        ->orderBy('graduating_students_requests')
        ->get();

        return view('courses::livewire.pages.course-requests-stats', [
            'reqs' => $reqs,
            'halls' => Hall::where('status', 'available')->orderBy('name')->get(),
            'professors' => User::Has('professor')->orderBy('first_name')->get(),
        ]);
    }
}
