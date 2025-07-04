<x-page :title="__('modules.professors.show', ['name' => $professor->first_name])" module="professors" show_index_button="true" show_edit_button="{{ $professor->national_id }}">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <div class="mb-3 row">
            <h5 class="col-sm-3 col-form-label fs-5">@lang('forms.image')</h5>
            <div class="col-sm-9 d-flex">
                <img src="{{ asset($professor->image ? 'storage/' . $professor->image : 'favicon.png') }}" alt="User image" class="img-thumbnail" width="120" height="90">
            </div>
        </div>

        <livewire:components.show-item label="forms.name" :data="$professor->full_name" />

        <livewire:components.show-item label="forms.national_id" :data="$professor->national_id" />

        <livewire:components.show-item label="forms.email" :data="$professor->email" />

        <livewire:components.show-item label="forms.phone" :data="$professor->phone" />

        <livewire:components.show-item label="forms.gender" :data="$professor->gender == 'm' ? __('forms.male') : __('forms.female')" />

    </div>
    <!--end::Body-->

</x-page>
