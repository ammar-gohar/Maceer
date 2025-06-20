<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ModeratorsIndex extends Component
{

    use WithPagination;

    public function delete($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-index', [
            'moderators' => User::has('moderator')->with(['moderator'])->paginate(15),
        ])->title(__('sidebar.moderators.index'));
    }
}
