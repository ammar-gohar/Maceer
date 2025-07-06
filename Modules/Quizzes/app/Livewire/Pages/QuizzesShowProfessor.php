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

    public function change_mark($id, $index)
    {
        dd($this->marks, $this->answers);
        $answer = Answer::with(['attempt', 'question'])->find($id)->first();

        $this->validate(['marks.'.$index => 'bail|required|decimal:0,2|min:0|max:' . $answer->question->marks]);

        $answer->update([
            'marks_obtained' => $this->marks[$index],
        ]);

        $answer->attempt()->update([
            'score' => array_sum($this->marks),
        ]);

        notyf()->success(__('modules.quizzes.score_updated.success'));

    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-show-professor');
    }
}
