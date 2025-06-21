<x-page :title="__('modules.professors.show', ['name' => $professor->first_name])" module="professors" show_index_button="true" show_edit_button="$professor->national_id">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name" :data="$professor->fullName()" />

        <livewire:components.show-item label="forms.national_id" :data="$professor->national_id" />

        <livewire:components.show-item label="forms.email" :data="$professor->email" />

        <livewire:components.show-item label="forms.phone" :data="$professor->phone" />

        <livewire:components.show-item label="forms.gender" :data="$professor->gender == 'm' ? __('forms.male') : __('forms.female')" />

    </div>
    <!--end::Body-->

</x-page>
