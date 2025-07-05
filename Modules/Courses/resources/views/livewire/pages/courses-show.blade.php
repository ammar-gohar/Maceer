<x-page title="modules.courses.show" module="courses" show_index_button="true" show_edit_button="{{ $course->code }}">

    <!--begin::Body-->
    <div class="px-4 card-body">

        <livewire:components.show-item label="forms.name_en" :data="$course->name" />

        <livewire:components.show-item label="forms.name_ar" :data="$course->name_ar" />

        <livewire:components.show-item label="forms.credits" :data="$course->credits" />

        <livewire:components.show-item label="forms.requirement" :data="$course->requirement" />

        <livewire:components.show-item label="forms.full_mark" :data="$course->full_mark" />

        <livewire:components.show-item label="forms.level" :data="$course->level->name" />

        <table class="table mb-4 table-bordered table-sm" style="font-size: 0.75rem;">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>@lang('modules.courses.code')</th>
                    <th>@lang('modules.courses.name_en')</th>
                    <th>@lang('modules.courses.name_ar')</th>
                    <th>@lang('modules.courses.level')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course->prerequests as $prerequest)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prerequest->code }}</td>
                        <td>{{ $prerequest->name }}</td>
                        <td>{{ $prerequest->name_ar }}</td>
                        <td>{{ $prerequest->level->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!--end::Body-->

</x-page>
