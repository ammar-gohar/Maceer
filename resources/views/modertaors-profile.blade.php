<x-layouts.app title="{{ __('general.profile') }}">
    <x-page title="{{ (App::isLocale('ar') ? 'مرحبًا، ' : 'Welcome, ') . "$moderator->first_name $moderator->last_name" }}" module="moderators">

        <!--begin::Body-->
        <div class="px-4 row card-body">

            <div class="mb-3 row">
                <h5 class="col-sm-3 col-form-label fs-5">@lang('forms.image')</h5>
                <div class="col-sm-9 d-flex">
                    <img src="{{ asset($moderator->image ? 'storage/' . $moderator->image : 'favicon.png') }}" alt="User image" class="img-thumbnail" width="120" height="90">
                </div>
            </div>

            <livewire:components.show-item label="forms.name" data="{{ "$moderator->first_name $moderator->middle_name $moderator->last_name" }}" />

            <livewire:components.show-item label="forms.national_id" :data="$moderator->national_id" />

            <livewire:components.show-item label="forms.email" :data="$moderator->email" />

            <livewire:components.show-item label="forms.phone" :data="$moderator->phone" />

            <livewire:components.show-item label="forms.gender" :data="$moderator->gender == 'm' ? __('forms.male') : __('forms.female')" />

        </div>

        <livewire:reset-password>
        <!--end::Body-->

    </x-page>
</x-layouts.app>
