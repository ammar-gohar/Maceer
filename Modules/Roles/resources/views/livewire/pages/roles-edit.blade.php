<div class="mx-auto my-4 card card-info card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header d-flex justify-content-between align-items-center">
        <div class="card-title w-50">@lang('forms.add_role')</div>
        <div class="text-end w-50">
            <a wire:navigate href="{{ route('roles.index') }}" class="btn btn-info ms-auto">@lang('sidebar.roles.index')</a>
        </div>
    </div>
    <!--end::Header-->
    @if ($status)
        <div class="alert alert-success w-75 mx-auto mt-2">
            @lang('modules.roles.success.update')
        </div>
    @endif
    <!--begin::Form-->
    <form wire:submit='save()' action="post">
      <!--begin::Body-->
      @csrf
      <div class="card-body">
        <div class="mb-3 row">
            <label for="roleName" class="col-sm-2 col-form-label">@lang('forms.name')</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="roleName" wire:model='name'>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
        <label for="rolePerms" class="col-sm-2 col-form-label">@lang('modules.roles.permissions')</label>
        <div class="col-sm-10 offset-sm-2">
            @foreach ($permissionsModules as $module => $modulePermissions)
                <div class="mb-5">
                    <div class="form-check ps-3">
                        <input class="form-check-input" type="checkbox" id="{{ $module.'Permissions' }}">
                        <label class="form-check-label" for="{{ $module.'Permissions' }}">
                        {{ $module }}
                        </label>
                    </div>
                    @foreach ($modulePermissions as $permission)
                        <div class="ps-5 form-check">
                            <input class="form-check-input" type="checkbox" id="{{ $module.$loop->iteration }}" value="{{ $permission->id }}" wire:model='permissions' {{ $permissions->contains($permission->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $module.$loop->iteration }}">
                            {{ $permission->name_ar }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @endforeach
                @error('permissions')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
          </div>
        </div>
      </div>
      <!--end::Body-->
      <!--begin::Footer-->
      <div class="card-footer">
        <button type="submit" class="btn btn-info">@lang('forms.create')</button>
        <button type="submit" class="btn float-end">Cancel</button>
      </div>
      <!--end::Footer-->
    </form>
    <!--end::Form-->
</div>
