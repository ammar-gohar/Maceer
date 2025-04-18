<?php

namespace Modules\Roles\Livewire\Pages;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;
class RolesCreate extends Component
{

    public $name;
    public $name_ar;
    public $permissions = [];
    public $status = false;
    public $prevPermissions = [];

    protected function rules()
    {
        return [
            'name' => ['bail', 'required', 'unique:roles,name', 'unique:roles,name_ar', 'min:3', 'string', 'regex:/[A-z]/'],
            'name_ar' => ['bail', 'required', 'unique:roles,name', 'unique:roles,name_ar', 'min:3', 'string'],
            'permissions' => ['bail', 'array'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $role = Role::create([
            'name' => $data['name'],
            'name_ar' => $data['name_ar'],
        ]);

        if($data['permissions']){
            $role->permissions()->sync($data['permissions']);
        };

        return $this->status = true;

    }

    public function render()
    {
        return view('roles::livewire.pages.roles-create', [
            'permissionsModules' => Permission::all()->sortBy('id')->groupBy('module'),
        ]);
    }
}
