<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsIndex extends Component
{

    use WithPagination;

    public function delete_student($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    public function render()
    {
        return view('students::livewire.pages.students-index', [
            'students' => User::role('student')->with(['student'])->paginate(15),
        ]);
    }
}
