<?php

namespace Modules\Roles\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;

class RolesShow extends Component
{

    public Role $role;

    public function mount(string $id)
    {
        $this->role = Role::findOrFail($id);
        $this->role->translatedName = App::isLocale('ar') ? $this->role->name_ar : $this->role->name;
    }

    public function delete()
    {
        $role = $this->role;
        if($role->undeleteble){
            return;
        } else {
            $role->delete();
        }
    }

    public function render()
    {
        return view('roles::livewire.pages.roles-show', [
            'permissionsModules' => Permission::whereHas('roles', function($q) {
                $q->where('id', $this->role->id);
            })->get()->groupBy('module')
        ]);
    }
}
