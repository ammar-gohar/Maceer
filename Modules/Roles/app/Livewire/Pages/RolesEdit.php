<?php

namespace Modules\Roles\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesEdit extends Component
{
    public Role $role;
    public $name;
    public $permissions;
    public $status = false;

    public function mount(int $id)
    {
        $role = Role::with(['permissions'])->findOrFail($id);
        if ($role->name == 'Super Admin') {
            return $this->redirect('/roles', navigate: true);
        }
        $this->role = $role;
        $this->name = App::isLocale('ar') ? $role->name_ar : $role->name;
        $this->permissions = $role->permissions()->pluck('id');
    }

    protected function rules()
    {
        $lang = App::isLocale('ar') ? '_ar' : '';
        return [
            'name' => ['bail', 'required', 'unique:roles,name,'.$this->role->id, 'unique:roles,name_ar,'.$this->role->id, 'min:3', 'string'],
            'permissions' => ['bail', 'array', 'exists:permissions,id'],
        ];
    }

    public function save()
    {

        if($this->role->name == 'Super Admin'){
            return;
        }

        $data = $this->validate();

        if(App::isLocale('ar')){
            $attributes['name_ar'] = $data['name'];
            $attributes['name'] = null;
        } else {
            $attributes['name'] = $data['name'];
            $attributes['name_ar'] = null;
        }

        $this->role->update($attributes);

        if($data['permissions']){
            $this->role->permissions()->sync($data['permissions']);
        };

        return $this->status = true;

    }

    public function render()
    {
        return view('roles::livewire.pages.roles-edit', [
            'permissionsModules' => Permission::all()->sortBy('name_'.App::currentLocale())->groupBy('module'),
        ]);
    }
}
