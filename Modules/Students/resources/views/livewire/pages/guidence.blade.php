<x-page title="sidebar.students.guidence" module="students">
    <div class="card-body">
        @can('students.guidence.edit')
            @if (Auth::user()->hasRole('Super Admin'))
                <div class="row">
                    <button type="button" class="w-auto btn btn-dark" wire:click='showGuidesModal()'>
                        @lang('modules.professors.guides')
                    </button>
                </div>
            @endif
        @endcan
        {{-- FILTERS --}}
        <div class="p-2 my-3 row" style="font-size: 1rem;">
            <div class="col-md-3">
                <input type="text" name="search" id="search" wire:model.live='search' placeholder="{{ App::isLocale('ar') ? 'بحث...' : 'Search...' }}" class="form-control">
            </div>
            <div class="mb-3 form-group row col-md-5 offset-3">
                <div class="col-md-9 d-flex">
                    <label for="sortBy" class="fw-bold me-2" style="white-space: nowrap; font-size:1rem;">@lang('general.sort_by'):</label>
                    <select id="sortBy" class="form-select form-control" wire:model.change='sortBy.0'>
                        <option value="name">@lang('modules.students.name')</option>
                        @if (!Auth::user()->hasRole('Super Admin'))
                            <option value="credits">@lang('modules.students.credits')</option>
                            <option value="gpa">@lang('modules.students.gpa')</option>
                        @else
                            <option value="guide_name">@lang('modules.students.guide')</option>
                        @endif
                        <option value="level">@lang('modules.students.level')</option>
                    </select>
                </div>
                <div class="px-0 col-md-3">
                    <select id="sortByOptions" class="form-select form-control" wire:model.change='sortBy.1'>
                        <option value="asc">@lang('general.sort_by_options.asc')</option>
                        <option value="desc">@lang('general.sort_by_options.desc')</option>
                    </select>
                </div>
            </div>
            <div class="dropdown col-md-1">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="p-2 dropdown-menu" style="z-index: 999; min-width: 20rem;">
                    <div class="mb-3 form-group">
                        <label for="levelFilter" class="mb-1 fw-bold">@lang('modules.students.level')</label>
                        <select id="levelFilter" class="form-select form-control" wire:model.change='levelFilter'>
                            <option value="all">{{ App::isLocale('ar') ? 'الجميع' : 'All' }}</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" wire:key='{{ $loop->iteration }}-levels'>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (Auth::user()->hasRole('Super Admin'))
                        <div class="mb-3 form-group">
                            <label for="guideFilter" class="mb-1 fw-bold">@lang('modules.students.guide')</label>
                            <select id="guideFilter" class="form-select form-control" wire:model.change='guideFilter'>
                                <option value="all">{{ App::isLocale('ar') ? 'الجميع' : 'All' }}</option>
                                <option value="no_guide">{{ App::isLocale('ar') ? 'بدون مرشد' : 'No guide' }}</option>
                                @foreach ($guides as $guide)
                                    <option value="{{ $guide->id }}" wire:key='{{ $loop->iteration }}-guides'>{{ $guide->first_name . ' ' . $guide->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- /FILTERS --}}
        @if ($students->count() > 0)
            <div style="overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>@lang('modules.students.academic_number')</th>
                            <th>@lang('modules.students.name')</th>
                            <th>@lang('modules.students.gender')</th>
                            <th>@lang('modules.students.level')</th>
                            @unless (Auth::user()->hasRole('Super Admin'))
                                <th>@lang('modules.students.credits')</th>
                                <th>@lang('modules.students.gpa')</th>
                            @else
                                <th>@lang('modules.students.guide')</th>
                            @endunless
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="align-middle" style="white-space: nowrap;">
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $student->academic_number }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->gender == 'm' ? __('forms.male') : __('forms.female') }}</td>
                                <td>{{ $student->level }}</td>
                                @unless (Auth::user()->hasRole('Super Admin'))
                                    <td>{{ $student->credits }}</td>
                                    <td>{{ $student->gpa }}</td>
                                @else
                                    <td>{{ $student->guide_name ?: '--'}}</td>
                                @endunless
                                <td>
                                    <a href="{{ route('docs.create', ['studentId' => $student->national_id]) }}" class="btn btn-sm btn-dark" style="white-space: nowrap;">
                                        {{ App::isLocale('ar') ? 'طباعة وثيقة' : 'Print doc' }}
                                    </a>
                                </td>
                                <td style="white-space: nowrap;">
                                    @can('students.guidence.edit')
                                        @if (Auth::user()->hasRole('Super Admin'))
                                            <button class="btn btn-sm btn-danger"
                                                wire:confirm='Are you sure you want to delete this?'
                                                wire:click='remove_guidence("{{ $student->student_id }}")'
                                                >
                                                    {{ App::isLocale('ar') ? 'إزالة الإرشاد' : 'Remove Guidence' }}
                                            </button>
                                            <button class="btn btn-sm btn-primary"
                                                wire:click='show_modal("{{ $student->student_id }}", "{{ $student->name }}", "{{ $student->guide_id }}")'
                                                >
                                                    {{ App::isLocale('ar') ? 'تغيير المرشد' : 'Change guide' }}
                                            </button>
                                        @endif
                                    @endcan
                                    @can('students.guidence')
                                        @unless (Auth::user()->hasRole('Super Admin'))
                                            @if ($semesterId)
                                                @if ($student->receipt_paied_at && $student->enrollments)
                                                    <button class="btn btn-sm btn-danger"
                                                    wire:click='approve_enrollments("{{ $student->id }}")'
                                                    >
                                                            {{ App::isLocale('ar') ? 'تصديق تسجيل المقررات' : 'Approve Enrollments' }}
                                                    </button>
                                                    <button class="btn btn-sm btn-primary"
                                                        wire:click='show_enrollments_modal("{{ $student->id }}", "{{ $student->name }}")'
                                                        >
                                                            {{ App::isLocale('ar') ? 'عرض المقررات المسجلة' : 'Show enrollments' }}
                                                    </button>
                                                @else
                                                    @lang('modules.reports.not_paied')
                                                @endif
                                            @endif
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.students.empty')</h3>
            </div>
        @endif
    </div>

    @if ($changeGuideModal)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">{{ App::isLocale('ar') ? 'تغيير المرشد' : 'Change guide' }}</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <form wire:submit='change_guide()' class="px-4 row form-group">
                        <div class="px-4 modal-body">
                            <div class="mb-3">
                                @if (is_array($changeGuideModal['name']))
                                    <strong>@lang('modules.students.name'):</strong> {{ count($changeGuideModal['name']) }}
                                @else
                                    <strong>@lang('modules.students.name'):</strong> {{ $changeGuideModal['name'] }}
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="course">@lang('modules.students.guide'):</label>
                                <select wire:model='newGuideId' class="mt-1 col-12 form-select">
                                    <option {{ !$changeGuideModal['guide'] ? 'selected' : '' }}>{{ App::isLocale('ar') ? 'اختر معلمًا' : 'Choose a professor' }}</option>
                                    @foreach ($guides as $guide)
                                        <option value="{{ $guide->id }}" wire:key='{{ $loop->iteration }}-guidess' {{ $changeGuideModal['guide'] == $guide->id ? 'selected' : '' }}>{{ $guide->first_name . ' ' . $guide->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('newGuideId')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="px-3 modal-footer">
                            <button type="submit" class="btn btn-dark">@lang('forms.update')</button>
                            <button type="button" class="btn btn-light" wire:click='close_modal()'>@lang('forms.close')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if ($enrollmentsModal)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog" style="max-width: 70%;">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">{{ App::isLocale('ar') ? 'عرض مقررات الطالب' : 'Show student enrollments' }}</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <div class="px-4 modal-body">
                        <div class="mb-3 row">
                            <div class="mb-2 col-md-6" style="font-size: 1.25rem;">
                                <strong>@lang('modules.students.name'):</strong> {{ $enrollmentsModal['name'] }}
                            </div>
                            <div class="mb-2 col-md-6" style="font-size: 1.25rem;">
                                <strong>@lang('modules.students.level'):</strong> {{ $enrollmentsModal['level'] }}
                            </div>
                            <div class="mb-2 col-md-6" style="font-size: 1.25rem;">
                                <strong>@lang('modules.students.gpa'):</strong> {{ $enrollmentsModal['gpa'] }}
                            </div>
                            <div class="mb-2 col-md-6" style="font-size: 1.25rem;">
                                <strong>@lang('modules.students.guide'):</strong> {{ $enrollmentsModal['guide'] }}
                            </div>
                            @if ($enrollmentsModal['approved_at'])
                                <div class="mb-2 col-md-12 text-danger" style="font-size: 1.25rem;">
                                    <strong>@lang('modules.students.approved_at'):</strong> {{ $enrollmentsModal['approved_at'] }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <!-- Student Info Table -->
                            <table class="table mb-4 table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>@lang('modules.courses.code')</th>
                                        <th>@lang('modules.courses.name')</th>
                                        <th>@lang('modules.courses.level')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enrollmentsModal['enrollments'] as $enrollment)
                                        <tr wire:key='enrollements-{{ $loop->iteration }}'>
                                            <td>{{ $enrollment->course->code ?? '--' }}</td>
                                            <td>{{ $enrollment->course->translated_name ?? '--' }}</td>
                                            <td>{{ $enrollment->course->level->name ?? '--' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Enrollments Table -->
                            @if (!empty($enrollmentsModal['courses']) && is_array($enrollmentsModal['courses']))
                                <table class="table table-striped table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('modules.courses.name')</th>
                                            <th>@lang('modules.courses.code')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($enrollmentsModal['courses'] as $index => $course)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $course['name'] ?? '--' }}</td>
                                                <td>{{ $course['code'] ?? '--' }}</td>
                                                <td>{{ $course['credits'] ?? '--' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                    <div class="px-3 modal-footer">
                        @if(!$enrollmentsModal['approved_at'])
                            <button type="button" class="btn btn-dark" wire:click='approve_enrollments("{{ $enrollmentsModal['id'] }}")'>@lang('forms.approve')</button>
                        @else
                            <a target="_blank" href="{{ route('reports.current.enrollment', ['semesterId' => $semesterId, 'studentId' => $enrollmentsModal['id']]) }}" type="button" class="btn btn-outline-primary">
                                <i class="bi bi-printer"></i> @lang('modules.reports.print')
                            </a>
                        @endif
                        <button type="button" class="btn btn-light" wire:click='close_modal()'>@lang('forms.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($guidesModal)
        <div class="modal" style="display: block; background: rgb(0,0,0,0.6);">
            <div class="modal-dialog" style="max-width: 70%;">
                <div class="modal-content">
                    <div class="px-3 modal-header">
                        <h5 class="modal-title">@lang('modules.professors.guides')</h5>
                        <button type="button" class="btn-close" wire:click='close_modal()'></button>
                    </div>
                    <div class="px-4 modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <h5>@lang('modules.professors.guides')</h5>
                            </div>
                            <!-- Student Info Table -->
                            <div style="max-height: 10rem; overflow-y:auto;">
                                <table class="table mb-4 table-striped table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>@lang('modules.courses.name')</th>
                                            <th>@lang('forms.gender')</th>
                                            <th>@lang('modules.professors.guidence_count')</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guidesModal['guides'] as $guide)
                                            <tr wire:key='guides-{{ $loop->iteration }}'>
                                                <td>{{ $guide->full_name }}</td>
                                                <td>{{ $guide->gender }}</td>
                                                <td>{{ $guide->guidence_count }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger" wire:click='remove_guide("{{ $guide->professor->id }}")'>
                                                        @lang('forms.remove')
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <h5>@lang('modules.professors.add_guide')</h5>
                            </div>
                            <!-- Student Info Table -->
                            <input type="text" class='form-control' placeholder="@lang('forms.search')" wire:model.live='guidesModal.search'>
                            <div style="max-height: 10rem; overflow-y:auto;">
                                <table class="table my-2 table-striped table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>@lang('modules.courses.name')</th>
                                            <th>@lang('forms.gender')</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($guidesModal['other_professors'] as $guide)
                                            <tr wire:key='guides-{{ $loop->iteration }}'>
                                                <td>{{ $guide->full_name }}</td>
                                                <td>{{ $guide->gender }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-dark" wire:click='add_guide("{{ $guide->professor->id }}")'>
                                                        @lang('forms.create')
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 modal-footer">
                        <span wire:loading wire:target='guide_students'>{{ App::isLocale('ar') ? 'انتظر رجاءً، قد يستغرق هذا وقتًا...' : 'Please wait, this might take a while...' }}</span>
                        <button type="button" class="btn btn-dark" wire:click='guide_students()' wire:target='guide_students' wire:loading.attr='disabled'>@lang('modules.professors.guide_students')</button>
                        <button type="button" class="btn btn-light" wire:click='close_modal()'>@lang('forms.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="clearfix card-footer">
        {{ $students->links() }}
    </div>

</x-page>
