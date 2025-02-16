<?php

namespace App\Livewire\Includes;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.includes.sidebar');
    }

    public function showRolesTable()
    {
        // dd('clicked');
        return $this->redirect('/roles', navigate: true);
    }
    public function showRolesCreateForm()
    {
        // dd('clicked');
        return $this->redirect('/roles/create', navigate: true);
    }
}
