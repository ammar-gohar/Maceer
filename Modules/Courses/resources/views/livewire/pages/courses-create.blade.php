<x-page module="courses" title="sidebar.courses.create" show_index_button="true">

    <!--begin::Form-->
    <form wire:submit='add_course()'>
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
                                <option value="">{{ App::isLocale('ar') ? 'اختر مستوى' : 'Choose a level' }}</option>
                                @foreach ($levels as $lvl)
                                    <option value="{{ $lvl->id }}" {{ $level == $lvl->id ? 'selected' : '' }}>{{ $lvl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('level')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <label for="level" class="form-label">@lang('forms.type')</label>
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
                        </div>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <label for="level" class="form-label">@lang('forms.requirement')</label>
                        <div class="input-group">
                            <select
                                name="requirement"
                                id="requirement"
                                class="form-select @error('requirement') is-invalid @enderror"
                                wire:model='requirement'
                                required>
                                <option value="university">University</option>
                                <option value="faculty">Faculty</option>
                                <option value="specialization">Specialization</option>
                            </select>
                        </div>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
            <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='add_course'>
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='add_course'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span wire:loading wire:target='add_course'>@lang('forms.creating')</span>
                <span wire:loading.remove wire:target='add_course'>@lang('forms.create')</span>
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
