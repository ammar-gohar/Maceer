<?php

namespace Modules\Courses\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Schedule as ModelsSchedule;
use Modules\Halls\Models\Hall;
use Modules\Semesters\Models\Semester;

class Schedule extends Component
{

    public $semesterId;
    public $showModal = [];
    public $course;
    public $hall;
    public $professor;

    public function mount()
    {
        $lastesSemester = Semester::latest()->first();
        if(!$lastesSemester || !$lastesSemester->is_current){
            $this->redirect('/semester');
            notyf()->error(__('notifications.no_semester'));
            return ;
        } else {
            $this->semesterId = $lastesSemester->id;
        };
    }

    public function show_modal(array $data)
    {
        $this->resetExcept('semesterId', 'showModal');
        $this->showModal = $data;
        if(count($data) > 2)
        {
            $this->course = $data[2];
            $this->hall = $data[3];
            $this->professor = $data[4];
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
            'professor' => 'bail|required|exists:users,id'
        ]);
        $data = [
            'course_id' => $validatedData['course'],
            'hall_id' => $validatedData['hall'],
            'professor_id' => $validatedData['professor'],
            'semester_id' => $this->semesterId,
            'day' => $this->showModal[0],
            'start_period' => (string) $this->showModal[1],
        ];
        if(count($this->showModal) > 2) {
            ModelsSchedule::find($this->showModal[5])->update($data);
            notyf()->success(__('modules.courses.schedule_success_update'));
            $this->resetExcept('semesterId');
        } else {
            ModelsSchedule::create($data);
            notyf()->success(__('modules.courses.schedule_success_add'));
            $this->resetExcept('semesterId');
        };
    }

    public function delete_schedule($id)
    {
        ModelsSchedule::find($id)->delete();
        notyf()->success(__('modules.courses.schedule_success_delete'));
        $this->resetExcept('semesterId');
    }

    public function render()
    {
        debugbar()->info(ModelsSchedule::with(['course', 'hall', 'professor'])->where('semester_id', $this->semesterId)->get()->groupBy('day'));

        if(Auth::user()->hasRole('student')){

            return view('courses::livewire.pages.schedule-show', [
                'schedules' => ModelsSchedule::with(['course', 'hall', 'professor'])->where('semester_id', $this->semesterId)->get()->groupBy('day'),
            ])->title(__('modules.courses.schedule'));

        } else {

            return view('courses::livewire.pages.schedule', [
                'schedules' => ModelsSchedule::with(['course', 'hall', 'professor'])->where('semester_id', $this->semesterId)->get()->groupBy('day'),

                'courses' => Course::latest()->orderBy(App::isLocal('ar') ? 'name_ar' : 'name')->get(),

                'halls' => Hall::latest()->orderBy('name')->get(),

                'professors' => User::latest()->has('professor')->orderBy('first_name')->get(),
            ])->title(__('modules.courses.schedule'));

        }
    }
}
