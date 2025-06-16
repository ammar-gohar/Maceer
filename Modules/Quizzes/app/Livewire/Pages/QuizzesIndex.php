<?php

namespace Modules\Quizzes\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Quizzes\Models\Attemp;
use Modules\Quizzes\Models\Quiz;
use Modules\Semesters\Models\Semester;

class QuizzesIndex extends Component
{

    public $courseId;
    public $courseName;
    public $attempts_index;
    public $attempt_show;

    public $semesterId;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
        $course = Course::findOrFail($this->courseId);
        $this->courseName = App::isLocale('ar') ? $course->name_ar : $course->name;
    }

    public function showModal($modal, $id)
    {
        if($modal == 'index') {
            $this->attempts_index = Attemp::where('quiz_id', $id)->get();
        } else if ($modal == 'show') {
            $attempt = Attemp::with(['answers'])->find($id);
            $this->attempt_show = (object) [
                'quiz' => Quiz::with(['questions', 'questions.options'])->find($attempt->quiz_id),
                'attempt' => $attempt,
            ];
        }
    }

    public function closeModal()
    {
        if($this->attempt_show) {
            $this->attempt_show = null;
        } else if ($this->attempts_index) {
            $this->attempts_index = null;
        }
    }

    public function delete_quiz($id)
    {
        Quiz::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-index', [
            'quizzes' => Quiz::with(['course', 'attempts'])
                            ->where('semester_id', $this->semesterId)
                            ->where('course_id', $this->courseId)
                            ->get(),
        ]);
    }
}
