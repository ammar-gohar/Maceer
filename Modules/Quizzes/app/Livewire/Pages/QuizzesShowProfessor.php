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
    }

    public function change_mark($id, $index)
    {
        $answer = Answer::with(['attempt', 'question'])->find($id)->first();

        $this->validate(['mark' => 'bail|required|decimal:0,2|min:0|max:' . $answer->question->marks]);

        $markDiff = $answer->marks_obtained - $this->marks[$index];
        $answer->update([
            'marks_obtained' => $this->marks[$index],
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
