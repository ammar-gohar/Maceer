<x-page title="modules.halls.show" module="halls" show_index_button="true" :show_edit_button="$hall->id">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name" :data="$hall->name" />

        <livewire:components.show-item label="forms.building" :data="$hall->building" />

        <livewire:components.show-item label="forms.floor" :data="$hall->floor" />

        <livewire:components.show-item label="forms.capacity" :data="$hall->capacity" />

        <livewire:components.show-item label="forms.type" :data="$hall->type" />

        <livewire:components.show-item label="forms.status" :data="$hall->status" />

    </div>
    <!--end::Body-->

</x-page>
