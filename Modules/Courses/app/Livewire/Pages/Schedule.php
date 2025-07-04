<?php

namespace Modules\Courses\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Schedule as ModelsSchedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Halls\Models\Hall;
use Modules\Semesters\Models\Semester;

class Schedule extends Component
{

    public $semesterId;
    public $showModal = [];
    public $course;
    public $hall;
    public $professor;
    public $courseId;
    public $max_enrollments_number = 0;
    public $enrolled_credits;
    public $students_enrolled;
    public $student_enrolled_credits;
    public $enrollments_end_date;

    public function mount()
    {
        $lastesSemester = Semester::where('is_current', 1)->first();
        if(!$lastesSemester){
            $this->redirect('/semester');
            notyf()->error(__('notifications.no_semester'));
            return ;
        } else {
            $this->semesterId = $lastesSemester->id;
            $this->enrollments_end_date = $lastesSemester->enrollments_end_date;
        };

    }

    public function show_modal(array $data)
    {
        $this->reset('course', 'hall', 'professor');
        $this->showModal = $data;
        if(count($data) > 2)
        {
            $schedule = ModelsSchedule::find($data[2]);
            $this->course = $schedule->course_id;
            $this->hall = $schedule->hall_id;
            $this->professor = $schedule->professor_id;
            $this->students_enrolled = $schedule->students_enrollments_number;
        }
    }

    public function close_modal()
    {
        $this->showModal = [];
    }

    public function add_schedule()
    {
        $validatedData = $this->validate([
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
            'day' => $this->showModal[0],
            'start_period' => (string) $this->showModal[1],
            'max_enrollments_number' => $validatedData['max_enrollments_number'],
        ];
        if(count($this->showModal) > 2) {
            ModelsSchedule::find($this->showModal[5])->update($data);
            notyf()->success(__('modules.courses.schedule_success_update'));
            $this->reset('course', 'hall', 'professor');
            $this->showModal = [];
        } else {
            ModelsSchedule::create($data);
            notyf()->success(__('modules.courses.schedule_success_add'));
            $this->reset('course', 'hall', 'professor');
            $this->showModal = [];
        };
    }

    public function delete_schedule($id)
    {
        ModelsSchedule::find($id)->delete();
        notyf()->success(__('modules.courses.schedule_success_delete'));
        $this->reset('course', 'hall', 'professor');
    }

    public function enroll_course(string $courseId, string $scheduleId)
    {

        $existedEnrollment = Enrollment::where('course_id', $courseId)->where('semester_id', $scheduleId)->first();
        $schedule = ModelsSchedule::find($scheduleId);

        if ($schedule->max_enrollments_number - $schedule->students_enrollments_number == 0) {
            return notyf()->error(__('modules.courses.no_seats_left'));
        }

        if ($existedEnrollment && $existedEnrollment->schedule_id == $scheduleId) {
            return notyf()->error(__('modules.courses.already_enrolled'));
        } elseif ($existedEnrollment) {
            return notyf()->error(__('modules.courses.enrolled_already'));
        };

        $enrollment = Enrollment::create([
            'course_id' => $courseId,
            'student_id' => Auth::user()->id,
            'semester_id' => $this->semesterId,
            'schedule_id' => $scheduleId
        ]);

        $schedule->update([
            'students_enrollments_number' => $schedule->students_enrollments_number + 1,
        ]);

        notyf()->success(__('modules.courses.enrollment_success'));
    }

    public function delete_enroll_course(string $id)
    {
        $enrollment = Enrollment::find($id);

        $schedule = ModelsSchedule::find($enrollment->schedule_id);
        $schedule->update([
            'students_enrollments_number' => $schedule->students_enrollments_number - 1,
        ]);

        $enrollment->delete();

        notyf()->success(__('modules.courses.enrollment_deleted'));
    }

    public function render()
    {

        // dd(Auth::user()->current_enrollments);

        if(Auth::user()->hasRole('student')){
            $this->student_enrolled_credits = Auth::user()->current_enrolled_courses->sum('credits');
            return view('courses::livewire.pages.schedule-show', [
                'schedules' => ModelsSchedule::with(['course', 'course.enrollments', 'course.level', 'course.prerequests', 'hall', 'professor'])
                                    ->where('semester_id', $this->semesterId)
                                    ->whereHas('course', fn ($q) =>
                                        $q
                                            ->whereHas('level', fn($q) =>
                                                $q->where('number', '<=', 1)
                                            )
                                            // ->whereDoesntHave('enrollments', fn($q) =>
                                            //     $q->whereNot('student_id', Auth::id())
                                            // )
                                            ->where(fn($q) =>
                                                $q
                                                    ->doesntHave('prerequests')
                                                    ->orWhereHas('prerequests', fn($q) =>
                                                        $q
                                                            ->whereHas('enrollments', fn($q) =>
                                                                $q->where('student_id', Auth::id())
                                                            )
                                                    )
                                            )
                                    )
                                    ->get()
                                    ->groupBy('day'),
                'enrollments' => Enrollment::with(['course', 'student'])->where('semester_id', $this->semesterId)->where('student_id', Auth::id())->get(),
            ])->title(__('modules.courses.schedule'));

        } else {

            return view('courses::livewire.pages.schedule', [
                'schedules' => ModelsSchedule::with(['course', 'course.level', 'hall', 'professor'])->where('semester_id', $this->semesterId)->get()->groupBy('day'),

                'courses' => Course::with(['level'])->orderBy(App::isLocal('ar') ? 'name_ar' : 'name')->get(),

                'halls' => Hall::latest()->orderBy('name')->get(),

                'professors' => User::latest()->has('professor')->orderBy('first_name')->get(),
            ])->title(__('modules.courses.schedule'));

        }
    }
}
