<x-page :title="__('modules.moderators.show', ['name' => $moderator->first_name])" module="moderators" show_index_button="true" :show_edit_button="$moderator->national_id">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name" :data="$moderator->fullName()" />

        <livewire:components.show-item label="forms.national_id" :data="$moderator->national_id" />

        <livewire:components.show-item label="forms.email" :data="$moderator->email" />

        <livewire:components.show-item label="forms.phone" :data="$moderator->phone" />

        <livewire:components.show-item label="forms.gender" :data="$moderator->gender == 'm' ? __('forms.male') : __('forms.female')" />

    </div>
    <!--end::Body-->

</x-page>
