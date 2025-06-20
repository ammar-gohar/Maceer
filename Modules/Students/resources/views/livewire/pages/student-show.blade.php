<x-page title="modules.students.show" module="students" show_index_button="true" :show_edit_button="$student->national_id">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name" :data="$student->fullName()" />

        <livewire:components.show-item label="forms.national_id" :data="$student->national_id" />

        <livewire:components.show-item label="forms.email" :data="$student->email" />

        <livewire:components.show-item label="forms.phone" :data="$student->phone" />

        <livewire:components.show-item label="forms.gender" :data="$student->gender == 'm' ? __('forms.male') : __('forms.female')" />

        <livewire:components.show-item label="forms.level" :data="$student->student->level->name" />

        <livewire:components.show-item label="forms.gpa" :data="$student->student->gpa" />

        <livewire:components.show-item label="forms.earned_credits" :data="$student->student->earned_credits" />

    </div>
    <!--end::Body-->

</x-page>
