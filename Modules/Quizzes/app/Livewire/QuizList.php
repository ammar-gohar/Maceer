<?php

namespace Modules\Quizzes\Livewire;

use Livewire\Component;

class QuizList extends Component
{
    public function render()
    {
        return view('quizzes::livewire.quiz-list');
    }
}
