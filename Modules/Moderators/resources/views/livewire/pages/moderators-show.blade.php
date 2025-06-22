<x-page :title="__('modules.moderators.show', ['name' => $moderator->first_name])" module="moderators" show_index_button="true" show_edit_button="$moderator->national_id">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <div class="mb-3 row">
            <h5 class="col-sm-3 col-form-label fs-5">@lang('forms.image')</h5>
            <div class="col-sm-9 d-flex">
                <img src="{{ asset($moderator->image ? 'storage/' . $moderator->image : 'favicon.png') }}" alt="User image" class="img-thumbnail" width="120" height="90">
            </div>
        </div>

        <livewire:components.show-item label="forms.name" :data="$moderator->full_name" />

        <livewire:components.show-item label="forms.national_id" :data="$moderator->national_id" />

        <livewire:components.show-item label="forms.email" :data="$moderator->email" />

        <livewire:components.show-item label="forms.phone" :data="$moderator->phone" />

        <livewire:components.show-item label="forms.gender" :data="$moderator->gender == 'm' ? __('forms.male') : __('forms.female')" />

    </div>
    <!--end::Body-->

</x-page>
