<x-page title="modules.roles.edit" module="roles" show_index_button="true" show-delete-form="true" undeleteble="{{ $role->undeleteble }}">

    <x-success-message :status="$status" module="roles" operation="update" />

    <!--begin::Form-->
    <form wire:submit='update()' action="post">
        <!--begin::Body-->
        @csrf
        <div class="card-body">
            <div class="row">

                <x-form-input name="name_ar" wire_model="name_ar" span="6"/>

                <x-form-input name="name_en" wire_model="name" span="6"/>

            </div>
            <div class="mb-3 row">
                <label for="rolePerms" class="col-sm-2 col-form-label">@lang('modules.roles.permissions')</label>
                <div class="col-sm-10 offset-sm-2 row">
                    @foreach ($permissionsModules as $module => $modulePermissions)
                        <div class="mb-5 col-lg-4">
                            <div class="form-check ps-3">
                                <input class="form-check-input" type="checkbox" id="{{ $module.'-Permissions' }}" onclick="checkAllCheckboxes('{{ $module }}', this)">
                                <label class="form-check-label fw-bold" for="{{ $module.'-Permissions' }}">
                                    @lang('sidebar.'.strtolower($module).'.title')
                                </label>
                            </div>
                            @foreach ($modulePermissions as $permission)
                                <div class="ps-5 form-check" wire:key='{{ $permission->id }}'>
                                    <input
                                        class="form-check-input {{ $module . '-checkbox' }}"
                                        type="checkbox"
                                        id="{{ $module.$loop->iteration }}"
                                        value="{{ $permission->id }}"
                                        wire:model.change='permissions'
                                        onclick="nestedCheckbox('{{ $module }}')"
                                        {{ $permissions->contains($permission->id) ? 'checked' : '' }}>
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
            <button type="submit" class="btn btn-dark" type="submit">
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='update'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span wire:loading wire:target='update'>@lang('forms.updating')</span>
                <span wire:loading.remove wire:target='update'>@lang('forms.update')</span>
            </button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->
</x-page>

@push('scripts')
    <script src="/js/checkboxes.js"></script>
@endpush
