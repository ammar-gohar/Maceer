<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsIndex extends Component
{

    use WithPagination;

    public function delete($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    public function render()
    {
        return view('students::livewire.pages.students-index', [
            'students' => User::has('student')->with(['student'])->paginate(15),
        ])->title(__('sidebar.students.index'));
    }
}
