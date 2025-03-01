<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Livewire\Component;

class StudentShow extends Component
{

    private $id;

    public function mount($national_id)
    {
        $this->id = $national_id;
    }

    public function render()
    {
        return view('students::livewire.pages.student-show', [
            'student' => User::with(['student'])->where('national_id', $this->id)->firstOrFail(),
        ]);
    }
}
