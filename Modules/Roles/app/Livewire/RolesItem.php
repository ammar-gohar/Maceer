<?php

namespace Modules\Roles\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Roles\Models\Role;

class RolesItem extends Component
{

    public $iteration;
    public Role $role;

    public function mount(int $iteration, Role $role)
    {
        $this->role = $role;
        $this->role->translatedName = App::isLocale('ar') ? $this->role->name_ar : $this->role->name;
        $this->iteration = $iteration;
    }

    public function render()
    {
        return view('roles::livewire.roles-item');
    }
}
