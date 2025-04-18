<?php

namespace Modules\Professors\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ProfessorsIndex extends Component
{

    use WithPagination;

    public function delete($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    public function render()
    {
        return view('professors::livewire.pages.professors-index', [
            'professors' => User::has('professor')->with(['professor'])->paginate(15),
        ])->title(__('sidebar.professors.index'));
    }
}
