<?php

namespace Modules\Courses\Livewire;

use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Grades\Models\Grade;

class ProfessorCourseStudentList extends Component
{

    public Enrollment $enroll;
    public $iteration;

    public $midterm = null;
    public $work = null;
    public $final = null;
    public $total = null;

    public function mount()
    {
        $this->midterm = $this->enroll->midterm_exam;
        $this->work = $this->enroll->work_mark;
        $this->final = $this->enroll->final_exam;

        if($this->midterm && $this->work && $this->final) {

            $this->total = $this->midterm + $this->work + $this->final;

        };
    }

    public function updated($prop)
    {

        if(in_array($prop, ['midterm', 'work', 'final'])) {
            $additional = [];
            if ($this->midterm && $this->work && $this->final) {

                $this->total = $this->midterm + $this->work + $this->final;

                $totalPercentage = number_format($this->total / $this->enroll->course->full_mark * 100, 2);

                $grade = Grade::where('max_percentage', '>=', $totalPercentage)
                                ->where('min_percentage', '<=', $totalPercentage)
                                ->first();

                $additional = [
                    'total_mark'            => $this->total,
                    'total_mark_percentage' => $totalPercentage,
                    'grade_id'              => $grade->id,
                    'final_gpa'             => $grade->gpa,
                    'quality_points'        => $grade->gpa * $this->enroll->course->credits,
                ];

            };

            $this->enroll->update([
                'midterm_exam' => $this->midterm,
                'work_mark'    => $this->work,
                'final_exam'   => $this->final,
                ...$additional,
            ]);
        }
    }

    public function render()
    {
        return view('courses::livewire.professor-course-student-list');
    }
}
