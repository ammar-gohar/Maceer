<?php

namespace Modules\Professors\Livewire\Pages;

use App\Models\User;
use Livewire\Component;

class ProfessorsShow extends Component
{
     private $id;

    public function mount($national_id)
    {
        $this->id = $national_id;
    }
    
    public function render()
    {
        return view('professors::livewire.pages.professors-show', [
            'professor' => User::with(['professor'])->where('national_id', $this->id)->firstOrFail(),
        ]);
    }
}
