<x-page module="courses" title="sidebar.courses.edit" show_index_button="true" :show_delete_button="true">

    <x-success-message :status="$status" module="courses" operation="update" />

    <!--begin::Form-->
    <form wire:submit='update_course()'>
        @csrf
        <!--begin::Body-->
        @if ($currentTab['show'] == 1)
            <div class="card-body" id="addCourseFirst">
                <!--begin::Row-->
                <div class="row g-3">
                    <!--begin::Col-->
                    <x-form-input name="name_en" wire_model="name" span="6" dir="ltr"/>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <x-form-input name="name_ar" wire_model="name_ar" span="6" />
                    <!--end::Col-->
                    <!--begin::Col-->
                    <x-form-input name="code" wire_model="code" />
                    <!--end::Col-->
                    <!--begin::Col-->
                    <x-form-input name="min_credits" wire_model="min_credits" type="number" min="0" max="180" dir="ltr" />
                    <!--end::Col-->
                    <!--begin::Col-->
                    <x-form-input name="credits" wire_model="credits" type="number" min="0" max="180" dir="ltr" />
                    <!--end::Col-->
                    <!--begin::Col-->
                    <x-form-input name="full_mark" wire_model="full_mark" dir="ltr" type="number" />
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <label for="level" class="form-label">@lang('forms.level')</label>
                        <div class="input-group">
                            <select
                                name="level"
                                id="level"
                                class="form-select @error('level') is-invalid @enderror"
                                wire:model='level'
                                required>
                                <option value="freshman" {{ $level == 'freshman' ? 'selected' : '' }}>Freshman</option>
                                <option value="sophomore" {{ $level == 'sophomore' ? 'selected' : '' }}>Sophomore</option>
                                <option value="junior" {{ $level == 'junior' ? 'selected' : '' }}>Junior</option>
                                <option value="senior-1" {{ $level == 'senior-1' ? 'selected' : '' }}>Senior-1</option>
                                <option value="senior-2" {{ $level == 'senior-2' ? 'selected' : '' }}>Senior-2</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <label for="level" class="form-label">@lang('type')</label>
                        <div class="input-group">
                            <select
                                name="type"
                                id="type"
                                class="form-select @error('type') is-invalid @enderror"
                                wire:model='type'
                                required>
                                <option value="core" {{ $level == 'core' ? 'selected' : '' }}>Core</option>
                                <option value="elected" {{ $level == 'elected' ? 'selected' : '' }}>Elected</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
        @elseif ($currentTab['show'] == 2)
            <div class="card-body" >
                <!--begin::Row-->
                <div class="row g-3">
                        <div class="col-12">
                            <label for="prerequest" class="form-label fs-5">@lang('forms.prerequest'):</label>
                            <ul class="p-0">
                                @foreach ($chosenCourses as $course)
                                    <li wire:click='remove_prerequest("{{ $course->id }}")' class="row prerequest-list">
                                        <p class="py-2 my-0 col-2">{{ $course->code }}</p>
                                        <p class="py-2 my-0 col-1"> - </p>
                                        <p class="py-2 my-0 col-5">{{ $course->name }}</p>
                                        <p class="py-2 my-0 col-4">{{ $course->name_ar }}</p>
                                    </li>
                                    @unless ($loop->last)
                                        <hr class="my-2" style="height: 2px;">
                                    @endunless
                                @endforeach
                            </ul>
                            @error('form.level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!--begin::Col-->
                        <div class="col-12">
                            <label for="prerequest" class="form-label fs-5">@lang('forms.prerequest'):</label>
                            <input type="text" wire:model.live='courseSearch' placeholder="@lang('forms.search')" class="mt-1 mb-3 form-control">
                            <ul class="p-0">
                                @foreach ($courses as $course)
                                    <li type="button" wire:click='add_prerequest("{{ $course->id }}")' class="row prerequest-list">
                                        <p class="py-2 my-0 col-2">{{ $course->code }}</p>
                                        <p class="py-2 my-0 col-1"> - </p>
                                        <p class="py-2 my-0 col-5">{{ $course->name }}</p>
                                        <p class="py-2 my-0 col-4">{{ $course->name_ar }}</p>
                                    </li>
                                    @unless ($loop->last)
                                        <hr class="my-2" style="height: 2px;">
                                    @endunless
                                @endforeach
                                <div class="mt-4">
                                    {{ $courses->links() }}
                                </div>
                            </ul>
                            @error('form.level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
        @endif
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="mt-3 card-footer">
            <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='ass_course'>
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='update_course'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span wire:loading wire:target='update_course'>@lang('forms.updating')</span>
                <span wire:loading.remove wire:target='update_course'>@lang('forms.update')</span>
            </button>
            <button type="button" class="border btn btn-light" type="submit" wire:click="change_tab()" wire:loading.attr='disabled'>
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='change_tab'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span>{{ $currentTab['btn'] }}</span>
            </button>
            <button type="reset" class="border btn btn-light" wire:click='reset()'>@lang('forms.reset')</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->

</x-page>

@push('styles')
    <style>
        .prerequest-list {
            cursor: pointer;
        }

        .prerequest-list:hover {
            background-color: lightgray;
            transition-duration: 200ms;
        }
    </style>
@endpush
