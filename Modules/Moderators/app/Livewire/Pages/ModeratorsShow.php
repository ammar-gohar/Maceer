<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Models\User;
use Livewire\Component;

class ModeratorsShow extends Component
{

    private $id;

    public function mount($national_id)
    {
        $this->id = $national_id;
    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-show', [
            'moderator' => User::with(['moderator'])->where('national_id', $this->id)->firstOrFail(),
        ]);
    }
}
