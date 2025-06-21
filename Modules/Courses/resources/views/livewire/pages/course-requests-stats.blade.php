<x-page module="courses" title="sidebar.courses.create">

    <div class="my-3 container">
        <div class="row mb-2">
            {{-- <h5 class="col-6">{{ App::isLocale('ar') ? 'عدد طلبات الخرّيجين' : 'Number of gruadating students requests' }}: {{ $requests->whereHas() }}</h5>
            <h5 class="col-6"></h5> --}}
        </div>
    </div>
        <!--begin::Body-->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>@lang('modules.courses.code')</th>
                    <th>@lang('modules.courses.name_ar')</th>
                    <th>@lang('modules.courses.name_en')</th>
                    <th>grads</th>
                    <th>others</th>
                    <th>total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reqs as $request)
                    @php
                        if($request->course->type == 'core') {
                            $text_color = 'text-dark';
                        } else if ($request->course->requirement == 'university') {
                            $text_color = 'text-warning-emphasis';
                        } else if ($request->course->requirement == 'faculty') {
                            $text_color = 'text-primary';;
                        } else if ($request->course->requirement ==  'program') {
                            $text_color = 'text-success';
                        }
                    @endphp
                    <tr class="align-middle" style="overflow-x: scroll;">
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td class="text-center">{{ $request->course->code }}</td>
                        <td dir="rtl" class="{{ $text_color }}">{{ $request->course->name_ar }}</td>
                        <td dir="ltr" class="{{ $text_color }}">{{ $request->course->name }}</td>
                        <td>{{ $request->graduating_students_requests }}</td>
                        <td>{{ $request->other_requests }}</td>
                        <td>{{ $request->total_requests }}</td>
                        <td>
                            <button type="button" class="btn" wire:click='show_modal("{{ $request->course->id }}")'>
                                {{ App::isLocale('ar') ? 'أضف للجدول الدراسي' : 'Add to schedule' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="mt-3 card-footer">
            <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='save_requests'>
                <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='save_requests'>
                    <span class="text-sm visually-hidden"></span>
                </div>
                <span wire:loading wire:target='save_requests'>@lang('forms.submitting')</span>
                <span wire:loading.remove wire:target='save_requests'>@lang('forms.submit')</span>
            </button>
            <button type="reset" class="border btn btn-light" wire:click='reset()'>@lang('forms.reset')</button>
        </div>
        <!--end::Footer-->
    @if ($showModal)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">@lang('modules.courses.schedule_course',[ 'code' => $courseCode, 'course' => $courseName])</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <form wire:submit='add_schedule()' class="px-4 row form-group">
                        <div class="px-4 modal-body">
                            <div class="mb-3">
                                <label for="course">@lang('general.day'):</label>
                                <select wire:model='day' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر يومًا' : 'Choose a day' }}</option>
                                    <option value="saturday">@lang('general.saturday')</option>
                                    <option value="sunday">@lang('general.sunday')</option>
                                    <option value="monday">@lang('general.monday')</option>
                                    <option value="tuesday">@lang('general.tuesday')</option>
                                    <option value="wednesday">@lang('general.wednesday')</option>
                                    <option value="thursday">@lang('general.thursday')</option>
                                </select>
                                @error('day')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="period">@lang('modules.courses.period'):</label>
                                <select wire:model='period' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر فترة' : 'Choose a perid' }}</option>
                                    <option value="1">1 - 2</option>
                                    <option value="3">3 - 4</option>
                                    <option value="5">5 - 6</option>
                                    <option value="7">7 - 8</option>
                                    <option value="9">9 - 10</option>
                                </select>
                                @error('period')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.halls.hall'):</label>
                                <select wire:model='hall' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر قاعة' : 'Choose a hall' }}</option>
                                    @foreach ($halls as $hall)
                                        <option value="{{ $hall->id }}" {{ $hall->id == $hall ? 'selected' : '' }}>{{ $hall->name }}</option>
                                    @endforeach
                                </select>
                                @error('hall')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.professors.professor'):</label>
                                <select wire:model='professor' class="mt-1 col-12 form-select">
                                    <option selected>{{ App::isLocale('ar') ? 'اختر معلم' : 'Choose a professor' }}</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}" {{ $professor->id == $professor ? 'selected' : '' }}>{{ $professor->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('professor')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.courses.enrollments_number'):</label>
                                <input type="number" class="mt-1 col-12 form-control" mix="0" wire:model='max_enrollments_number'>
                                @error('max_enrollments_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="px-3 modal-footer">
                            <button type="submit" class="btn btn-dark">@lang('forms.create')</button>
                            <button type="button" class="btn btn-secondary" wire:click='close_modal()'>@lang('forms.close')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-page>
