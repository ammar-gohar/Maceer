<x-page show-index-button="true" show-edit-button="{{ $role->id }}" title="modules.roles.show" module="roles">
    <!--begin::Body-->
    <div class="card-body">
        <div class="mb-3 row">
            <livewire:components.show-item label="forms.name_ar" :data="$role->name_ar" />
            <livewire:components.show-item label="forms.name_en" :data="$role->name" />
            @if ($role->name="Super Admin")
                <livewire:components.show-item label="forms.permissions" data="*">
            @else
                    <livewire:components.show-item label="forms.permissions" data="">
            @endif
            <div class="col-sm-10 offset-sm-2">
                @unless ($role->name == "Super Admin")
                    @foreach ($permissionsModules as $module => $modulePermissions)
                        <div class="mb-5">
                            <div class="form-check ps-3">
                                <h6 class="mb-2 form-check-label" for="{{ $module.'Permissions' }}">
                                    @lang('sidebar.'.strtolower($module).'.title')
                                </h6>
                            </div>
                            @foreach ($modulePermissions as $permission)
                                <div class="ps-5 form-check">
                                    <label class="form-check-label" for="{{ $module.$loop->iteration }}">
                                        {{ $permission->name_ar }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endunless
            </div>
        </div>
    </div>
    <!--end::Body-->
</x-page>
