<x-page module="professors" title="sidebar.professors.create" :show_index_button="true">

    <!--begin::Form-->
    <form wire:submit='store()'>
        @csrf
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Row-->
            <div class="row g-3">
                <!--begin::Col-->
                <x-form-input name="first_name" wire_model="form.first_name" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="middle_name" wire_model="form.middle_name" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="last_name" wire_model="form.last_name" span="4" />
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="national_id" wire_model="form.national_id" dir="ltr"/>
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="phone" wire_model="form.phone" dir="ltr"/>
                <!--end::Col-->
                <!--begin::Col-->
                <x-form-input name="email" type="email" wire_model="form.email" dir="ltr"/>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6">
                    <label for="validationCustom04" class="form-label">@lang('forms.gender')</label>
                    <div class="d-flex input-group justify-content-evenly">
                        <div class="d-flex">
                            <input type="radio" name="gender" id="genderM" class="me-2 form-check-input" value="m" {{ old('gender') == 'm' ? 'checked' : '' }} wire:model.live='form.gender'>
                            <label for="genderM" class="form-label form-check-label">@lang('forms.male')</label>
                        </div>
                        <div class="d-flex">
                            <input type="radio" name="gender" id="genderF" value="f" class="me-2 form-check-input" {{ old('gender') == 'f' ? 'checked' : '' }} wire:model.live='form.gender'>
                            <label for="genderF" class="form-label form-check-label">@lang('forms.female')</label>
                        </div>
                    </div>
                    @error('form.gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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
            <button type="reset" class="border btn btn-light" type="submit" wire:click='reset_inputs()'>@lang('forms.reset')</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->

</x-page>
