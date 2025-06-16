<?php

namespace Modules\Quizzes\Livewire\Pages;

use Livewire\Component;
use Modules\Quizzes\Models\Answer;

class QuizzesShowProfessor extends Component
{

    public $quiz;
    public $attempt;
    public $answers;
    public $mark;

    public function change_mark($id)
    {
        if($this->mark){
            $answer = Answer::with(['attempt', 'question'])->find($id)->first();

            $this->validate(['mark' => 'bail|required|decimal:0,2|min:0|max:' . $answer->question->marks]);

            $markDiff = $answer->marks_obtained - $this->mark;
            $answer->update([
                'marks_obtained' => $this->mark,
            ]);
            $answer->attempt()->update([
                'score' => $answer->attempt->score - $markDiff,
            ]);

            return notyf()->success(__('modules.quizzes.score_updated.success'));
        } else {
            return notyf()->error(__('modules.quizzes.score_updated.fail'));
        }
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-show-professor');
    }
}
