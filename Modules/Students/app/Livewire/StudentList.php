<?php

namespace Modules\Students\Livewire;

use Livewire\Component;

class StudentList extends Component
{
    public function render()
    {
        return view('students::livewire.student-list');
    }
}
