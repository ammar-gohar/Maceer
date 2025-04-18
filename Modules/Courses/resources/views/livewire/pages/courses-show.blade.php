<x-page title="modules.courses.show" module="courses" show-index-button="true" show-edit-button="{{ $course->code }}">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name_en" :data="$course->name" />

        <livewire:components.show-item label="forms.name_ar" :data="$course->name_ar" />

        <livewire:components.show-item label="forms.credits" :data="$course->credits" />

        <livewire:components.show-item label="forms.requirement" :data="$course->requirement" />

        <livewire:components.show-item label="forms.full_mark" :data="$course->full_mark" />

        <livewire:components.show-item label="forms.level" :data="$course->level" />

    </div>
    <!--end::Body-->

</x-page>
