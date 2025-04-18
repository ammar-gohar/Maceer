<?php

namespace Modules\Professors\Livewire;

use App\Models\User;
use Livewire\Component;

class ProfessorsList extends Component
{

    public User $professor;
    public $loop;

    public function mount($loop)
    {
        $this->loop = $loop;
    }

    public function render()
    {
        return view('professors::livewire.professors-list', [
            'professor' => $this->professor,
        ]);
    }
}
