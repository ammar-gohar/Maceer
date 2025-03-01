<?php

namespace Modules\Students\Livewire;

use App\Models\User;
use Livewire\Component;

class StudentList extends Component
{

    public User $student;
    public $loop;

    public function mount($loop)
    {
        $this->loop = $loop;
    }

    public function render()
    {
        return view('students::livewire.student-list', [
            'student' => $this->student,
        ]);
    }
}
