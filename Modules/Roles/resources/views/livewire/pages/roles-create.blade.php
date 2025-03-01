<x-page title="modules.roles.create" module="roles" show-index-button="true">

    <x-success-message :status="$status" module="roles" operation="store" />

    <!--begin::Form-->
    <form wire:submit='save()' action="post">
        <!--begin::Body-->
        @csrf
        <div class="card-body">

            <div class="row">

                <x-form-input name="name_ar" wire_model="name_ar" span="6"/>

                <x-form-input name="name_en" wire_model="name" span="6"/>

            </div>

            <div class="my-3 row">
                <label for="rolePerms" class="col-sm-2 col-form-label">@lang('modules.roles.permissions')</label>
                <div class="col-sm-10 offset-sm-2">
                    @foreach ($permissionsModules as $module => $modulePermissions)
                        <div class="mb-5" wire:key='{{ $module }}'>
                            <div class="form-check ps-3">
                                <input class="form-check-input" type="checkbox" id="{{ $module.'Permissions' }}" value="{{ $modulePermissions->pluck('id') }}" wire:model.change="permissions">
                                <label class="form-check-label" for="{{ $module.'Permissions' }}">
                                    @lang('sidebar.'.strtolower($module).'.title')
                                </label>
                            </div>
                            @foreach ($modulePermissions as $permission)
                                <div class="ps-5 form-check" wire:key='{{ $permission->id }}'>
                                    <input class="form-check-input" type="checkbox" id="{{ $module.$loop->iteration }}" value="{{ $permission->id }}" wire:model='permissions'>
                                    <label class="form-check-label" for="{{ $module.$loop->iteration }}">
                                    {{ App::isLocale('ar') ? $permission->name_ar : $permission->name_en }}
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
            <button type="submit" class="btn btn-dark">@lang('forms.create')</button>
            <button type="reset" class="border btn btn-light">@lang('forms.reset')</button>
        </div>
        <!--end::Footer-->

    </form>
    <!--end::Form-->
</x-page>
