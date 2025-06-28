<x-page title="modules.students.show" module="students" show_index_button="true" show_edit_button="{{ $student->national_id }}">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <div class="mb-3 row">
            <h5 class="col-sm-3 col-form-label fs-5">@lang('forms.image')</h5>
            <div class="col-sm-9 d-flex">
                <img src="{{ asset($student->image ? 'storage/' . $student->image : 'favicon.png') }}" alt="User image" class="img-thumbnail" width="120" height="90">
            </div>
        </div>

        <livewire:components.show-item label="forms.name" :data="$student->full_name" />

        <livewire:components.show-item label="forms.national_id" :data="$student->national_id" />

        <livewire:components.show-item label="forms.email" :data="$student->email" />

        <livewire:components.show-item label="forms.phone" :data="$student->phone" />

        <livewire:components.show-item label="forms.gender" :data="$student->gender == 'm' ? __('forms.male') : __('forms.female')" />

        <livewire:components.show-item label="forms.level" :data="$student->student->level->name" />

        <livewire:components.show-item label="forms.gpa" :data="$student->student->gpa" />

        <livewire:components.show-item label="forms.total_earned_credits" :data="$student->student->total_earned_credits" />

    </div>
    <!--end::Body-->

</x-page>
