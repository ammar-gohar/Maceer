<x-page title="modules.roles.edit" module="roles" show-index-button="true">

    <x-success-message :status="$status" module="roles" operation="update" />

    <!--begin::Form-->
    <form wire:submit='update()' action="post">
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
        <button type="submit" class="btn btn-secondary">@lang('forms.create')</button>
        <button type="submit" class="btn float-end">Cancel</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->
</x-page>
