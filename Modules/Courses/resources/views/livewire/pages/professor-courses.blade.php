<x-page title="sidebar.courses.professor-show" module="courses">

    <div class="card-body" style="overflow-x: scroll;">
        @if ($courses->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="white-space: nowrap;">
                        <th class="text-center">#</th>
                        <th>@lang('modules.courses.code')</th>
                        <th>{{ App::isLocale('ar')  ? 'اسم المقرر' : 'Course name' }}</th>
                        <th>@lang('modules.courses.enrollments_count')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr wire:key='course-{{ $loop->iteration }}'>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $course->code }}</td>
                            <td class="text-center">{{ $course->name }}</td>
                            <td class="text-center">{{ $course->current_semester_enrollments_count }}</td>
                            <td>
                                <a href="{{ route('courses.quizzes', ['courseId' => $course->id]) }}" class="btn btn-sm btn-primary" title="{{ App::isLocale('ar') ? 'الامتحانات' : 'Quizzes' }}">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-secondary" wire:click='show_modal("{{ $course->id }}", "{{ $course->name }}")'>
                                    <i class="fa-solid fa-eye"></i> {{ App::isLocale('ar') ? 'الدرجات' : 'Marks' }}
                                </button>
                                <a href="{{ route('courses.library', ['code' => $course->code]) }}" class="btn btn-sm btn-warning" title="{{ App::isLocale('ar') ? 'المكتبة' : 'Library' }}">
                                    <i class="bi bi-folder-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.courses.empty')</h3>
            </div>
        @endif
    </div>

    @if ($modal)
        <div class="modal" id="exampleModal" aria-labelledby="sturdentsModal" style="opacity: 1; display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog" style="max-width:none;">
                <div class="mx-auto modal-content w-75 ">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sturdentsModal">@lang('modules.courses.show_marks', ['course' => $modal['courseName']])</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='close_modal()'></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-2 px-5 my-1 row">
                            <div class="form-check form-switch col-4">
                                <input class="form-check-input" type="checkbox" name="publishMarks" id="publishMidterm" wire:model.change='shownColumns' value="midterm_exam" style="font-size: 1.25rem;">
                                <label class="form-check-label" for="publishMidterm">@lang('forms.publish_midterm')</label>
                            </div>
                            <div class="form-check form-switch col-4">
                                <input class="form-check-input" type="checkbox" name="publishMarks" id="publishWork" wire:model.change='shownColumns'
                                value="work_marks" style="font-size: 1.25rem;">
                                <label class="form-check-label" for="publishWork">@lang('forms.publish_work')</label>
                            </div>
                            <div class="form-check form-switch col-4">
                                <input class="form-check-input" type="checkbox" name="publishMarks" id="publishFinal" wire:model.change='shownColumns'
                                value="final_exam" style="font-size: 1.25rem;">
                                <label class="form-check-label" for="publishFinal">@lang('forms.publish_final')</label>
                            </div>
                            <div class="form-check form-switch col-4">
                                <input class="form-check-input" type="checkbox" name="publishMarks" id="publishFinal" wire:model.change='shownColumns'
                                value="total_mark" style="font-size: 1.25rem;">
                                <label class="form-check-label" for="publishFinal">@lang('forms.publish_final')</label>
                            </div>
                        </div>
                        <select name="schedule" wire:model.change='shownScheduleId' class="mb-3 form-select">
                            @foreach ($modal['schedules'] as $schedule)
                                <option value="{{ $schedule->id }}" wire:key="scheudule-shown-{{ $loop->iteration }}">
                                    {{ App::isLocale('ar') ? (' المجوعة' . $loop->iteration) : ('Group ' . $loop->iteration) }}: {{ __('general.' . $schedule->day) }} {{ App::isLocale('ar') ? 'الفترة' : 'period' }} {{ $schedule->start_period . ' - ' . $schedule->start_period + 1 }}
                                </option>
                            @endforeach
                        </select>

                        @if ($modal['enrollments']->count() > 0)
                            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th class="text-center">#</th>
                                        <th>@lang('modules.students.name')</th>
                                        <th>@lang('modules.courses.midterm_exam')</th>
                                        <th>@lang('modules.courses.work_mark')</th>
                                        <th>@lang('modules.courses.final_exam')</th>
                                        <th>@lang('modules.courses.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modal['enrollments'] as $enroll)
                                        <livewire:courses::professor-course-student-list :enroll="$enroll" wire:key="enrollment-{{ $loop->iteration }}" :iteration="$loop->iteration">
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center alert alert-secondary fw-none">
                                <h3 class="my-0 fw-normal">@lang('modules.students.empty')</h3>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='close_modal()'>@lang('forms.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-page>
