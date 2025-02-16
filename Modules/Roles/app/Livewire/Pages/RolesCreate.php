<?php

namespace Modules\Roles\Livewire\Pages;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{

    public $name;
    public $permissions = [];
    public $status = false;

    protected function rules()
    {
        $lang = App::isLocale('ar') ? '_ar' : '';
        return [
            'name' => ['bail', 'required', 'unique:roles,name', 'unique:roles,name_ar', 'min:3', 'string'],
            'permissions' => ['bail', 'array', 'exists:permissions,id'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        if(App::isLocale('ar')){
            $attributes['name_ar'] = $data['name'];
            $attributes['name'] = null;
        } else {
            $attributes['name'] = $data['name'];
            $attributes['name_ar'] = null;
        }

        $role = Role::create($attributes);

        if($data['permissions']){
            $role->permissions()->sync($data['permissions']);
        };

        return $this->status = true;

    }

    public function goToRoles()
    {
        return $this->redirect('/roles', navigate:true);
    }

    public function render()
    {
        return view('roles::livewire.pages.roles-create', [
            'permissionsModules' => Permission::all()->sortBy('name_'.App::currentLocale())->groupBy('module'),
        ]);
    }
}
