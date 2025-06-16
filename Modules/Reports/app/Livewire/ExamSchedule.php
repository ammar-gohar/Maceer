<?php

namespace Modules\Reports\Livewire;

use App\Models\User;
use Livewire\Component;
use Modules\Semesters\Models\Semester;

class ExamSchedule extends Component
{
    public $startDate;
    public $endDate;
    public $includeFridays = false;
    public $holidays = [''];
    public $semesterId;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;

        if(!$this->semesterId)
        {
            return $this->redirect('/semester');
        }
    }

    public function addHoliday()
    {
        $this->holidays[] = '';
    }

    public function removeHoliday($index)
    {
        unset($this->holidays[$index]);
        $this->holidays = array_values($this->holidays); // Reindex array
    }

    public function generate_exam()
    {
        $data = $this->validate([
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'holidays.*'  => 'nullable|date|after_or_equal:start_date|before_or_equal:end_date',
        ]);

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $holidays = $data['holidays']; // ARRAY

        $students = User::with(['current_enrollments', 'current_enrollments.course'])->has('current_enrollments')->get();


        // =================================================================================
        // =================================================================================
        // NOTE:: To get you need to use foreach loop on ($students as $student) to get the current enrollments of each student
        // ================================================================
        // IN FOREACH LOOP, to get the course name of A STUDENT use: $student->current_enrollments->pluck('course.*.name')
        // ================================================================
        // You can use another foreach loop on ($student->current_enrollments as $course) to get each course of a student. Then you can get the course name as $course->name
        // =================================================================================
        // =================================================================================

        notyf()->success('message', 'Exam generated successfully!');
    }

    public function render()
    {
        return view('reports::livewire.exam-schedule');
    }
}
