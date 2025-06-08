<?php

namespace Modules\Quizzes\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Quizzes\Models\Quiz;
use Modules\Semesters\Livewire\Pages\Semester;
use Modules\Semesters\Models\Semester as ModelsSemester;

class QuizzesIndexStudent extends Component
{

    public $semesterId;
    public $showModal = null;

    public function mount()
    {
        $this->semesterId = ModelsSemester::where('is_current', 1)->first()?->id;
    }

    public function show_modal($id)
    {
        $this->showModal = $id;
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-index-student', [
            'quizzes' => Quiz::with(['attempts', 'course'])
                                ->where('semester_id', $this->semesterId)
                                ->whereHas('course', fn($q) => $q
                                    ->whereHas('enrollments', fn($q) => $q
                                        ->where('student_id', Auth::id())
                                        ->where('semester_id', $this->semesterId)
                                    )
                                )
                                ->get()
        ]);
    }
}
