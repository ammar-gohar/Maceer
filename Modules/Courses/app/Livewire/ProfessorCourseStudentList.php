<?php

namespace Modules\Courses\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Grades\Models\Grade;
use Modules\Levels\Models\Level;

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

            if($this->midterm < 0 || $this->work < 0 || $this->final < 0)
            {
                return notyf()->error(App::isLocale('ar') ? 'لا يمكنك إدخال رقم بالسالب' : 'You can\'t insert a negative number');

            };

            if ($this->midterm >= 0 && $this->work >= 0 && $this->final >= 0) {

                $this->total = $this->midterm + $this->work + $this->final;

                if($this->total > $this->enroll->course->full_mark)
                {
                    return notyf()->error(App::isLocale('ar') ? 'عدد الدرجات أكبر من درجة المادة' : 'Total marks is more than course full mark');
                }

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

                $student = User::find($this->enroll->student_id);
                $totalQulaity = $student->student->quality_points + $this->enroll->course->credits * $grade->gpa;
                $totalCredits = $student->student->total_earned_credits + $this->enroll->course->credits;

                $ueec = $student->student->unversity_elected_earned_credits;
                $feec = $student->student->faculty_elected_earned_credits;
                $peec = $student->student->program_elected_earned_credits;
                $cec = $student->student->core_earned_credits;

                if($this->enroll->course->type == 'core')
                {
                    $cec += $this->enroll->course->credits;
                } else {
                    match ($this->enroll->course->requirement) {
                        'university' => $ueec += $this->enroll->course->credits,
                        'faculty' => $feec += $this->enroll->course->credits,
                        'specialization' => $peec += $this->enroll->course->credits,
                    };
                }

                if($student)
                {
                    $fGpa = $totalQulaity / $totalCredits;

                    $level = Level::where('min_credits', '<=', $totalCredits)
                                    ->orderBy('number', 'desc')
                                    ->first();

                    $max = 18;
                    switch ($fGpa) {
                        case $fGpa >= 3.0:
                            $max = 21;
                            break;
                        case $fGpa >= 2.0:
                            $max = 18;
                            break;
                        default:
                            $max = 15;
                            break;
                    };

                    $student->student->update([
                        'gpa' => $fGpa,
                        'quality_points' => $totalQulaity,
                        'level_id' => $level->id,
                        'unversity_elected_earned_credits' => $ueec,
                        'faculty_elected_earned_credits' => $feec,
                        'program_elected_earned_credits' => $peec,
                        'core_earned_credits' => $cec,
                        'total_earned_credits' => $totalCredits,
                        'maximum_credits_to_enroll' => $max,
                    ]);
                }

                $this->enroll->update([
                    'midterm_exam' => $this->midterm,
                    'work_mark'    => $this->work,
                    'final_exam'   => $this->final,
                    ...$additional,
                ]);
            };
        }
    }

    public function render()
    {
        return view('courses::livewire.professor-course-student-list');
    }
}
