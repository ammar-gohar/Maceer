<div class="mx-auto my-4 card card-info card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header d-flex justify-content-between align-items-center">
        <div class="card-title w-50">@lang('forms.add_role')</div>
        <div class="text-end w-50">
            <a wire:navigate href="{{ route('roles.index') }}" class="btn btn-info ms-auto">@lang('sidebar.roles.index')</a>
            <a wire:navigate href="{{ route('roles.edit', $role->id) }}" class="btn btn-info ms-auto">@lang('sidebar.roles.edit')</a>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <div>
      <!--begin::Body-->
      <div class="card-body">
        <div class="mb-3 row">
            <label for="roleName" class="col-sm-2 col-form-label">@lang('forms.name')</label>
            <div class="col-sm-10">
                    <p>{{ $role->translatedName }}</p>
            </div>
        </div>
        <div class="mb-3 row">
        <label for="rolePerms" class="col-sm-2 col-form-label">@lang('modules.roles.permissions')</label>
        <div class="col-sm-10 offset-sm-2">
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
          </div>
        </div>
      </div>
      <!--end::Body-->
    </div>
    <!--end::Form-->
</div>
