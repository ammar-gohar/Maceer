<?php

namespace Modules\Quizzes\Livewire\Pages;

use Livewire\Component;
use Modules\Quizzes\Models\Answer;

class QuizzesShowProfessor extends Component
{

    public $quiz;
    public $attempt;
    public $answers;
    public $marks = [];

    public function mount()
    {
        $marks = $this->answers->pluck('marks_obtained')->toArray();
    }

    public function change_mark($id)
    {
        $answer = Answer::with(['attempt', 'question'])->find($id)->first();

        $this->validate(['mark' => 'bail|required|decimal:0,2|min:0|max:' . $answer->question->marks]);

        $markDiff = $answer->marks_obtained - $this->mark;
        $answer->update([
            'marks_obtained' => $this->mark,
        ]);
        $answer->attempt()->update([
            'score' => $answer->attempt->score - $markDiff,
        ]);
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-show-professor');
    }
}
