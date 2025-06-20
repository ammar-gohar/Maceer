<?php

namespace Modules\Moderators\Livewire;

use App\Models\User;
use Livewire\Component;

class ModeratorList extends Component
{

    public User $moderator;
    public $loop;

    public function mount($loop)
    {
        $this->loop = $loop;
    }

    public function render()
    {
        return view('moderators::livewire.moderator-list', [
            'moderator' => $this->moderator,
        ]);
    }
}
