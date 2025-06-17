<x-page module="halls" title="sidebar.halls.create" show_index_button="true">

    <!--begin::Form-->
    <form wire:submit='store()'>
        @csrf
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Row-->
            <div class="row g-3">
                <!--begin::Col-->
                <x-form-input name="name" wire_model="name" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="building" wire_model="building" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="floor" wire_model="floor" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="capacity" wire_model="capacity" dir="ltr" type="number" min="0" step="1"/>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6">
                    <label for="hallType" class="form-label">@lang('forms.type')</label>
                    <div class="input-group">
                        <select
                            name="type"
                            id="hallType"
                            class="form-select @error('type') is-invalid @enderror"
                            wire:model='type'
                            required>
                            <option value="theatre">@lang('modules.halls.types.theatre')</option>
                            <option value="lab">@lang('modules.halls.types.lab')</option>
                        </select>
                    </div>
                    @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6">
                    <label for="hallStatus" class="form-label">@lang('forms.status')</label>
                    <div class="input-group">
                        <select
                            name="status"
                            id="hallStatus"
                            class="form-select @error('status') is-invalid @enderror"
                            wire:model='status'
                            required>
                            <option value="available">@lang('modules.halls.status.available')</option>
                            <option value="under_maintenance">@lang('modules.halls.status.under_maintenance')</option>
                            <option value="reserved">@lang('modules.halls.status.reserved')</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="mt-3 card-footer">
            <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='store'>
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='store'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span wire:loading wire:target='store'>@lang('forms.creating')</span>
                <span wire:loading.remove wire:target='store'>@lang('forms.create')</span>
            </button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->

</x-page>
