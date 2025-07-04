<x-page title="sidebar.reports.index" module="reports">

    <div class="card-body">
        @unless(Auth::user()->hasRole('Super Admin'))
            @can('reports.request')
                <form wire:submit='add_request()' class="p-2 my-3 row">
                    <div class="my-2 col-md-6">
                        <label for="type">@lang('modules.reports.type') *</label>
                        <select name="type" id="type" wire:model.change='type' class="mt-2 form-select">
                            <option value="transcript">@lang('modules.reports.transcript')</option>
                            <option value="registeration_proof">@lang('modules.reports.registeration_proof')</option>
                            <option value="re-garding">@lang('modules.reports.re-garding')</option>
                        </select>
                    </div>
                    <div class="my-2 col-md-6">
                        <label for="type">@lang('modules.reports.concern')</label>
                        <input type="text" id="concern" name="concern" wire:model.change='concern' class="mt-2 form-control">
                    </div>
                    <div class="my-2 col-md-6">
                        <label for="type">@lang('forms.notes')</label>
                        <textarea type="text" id="notes" name="notes" wire:model.change='notes' class="mt-2 form-control"></textarea>
                    </div>
                    <div class="my-2 col-md-6">
                        <label for="">@lang('modules.reports.language') *</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="radio" id="langar" name="language" wire:model.change='language' class="mt-2 form-check-input me-2" value="ar">
                                <label for="langar">العربية</label>
                            </div>

                            <div class="col-6">
                                <input type="radio" id="langen" name="language" wire:model.change='language' class="mt-2 form-check-input me-2" value="en">
                                <label for="langen">English</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="w-auto mt-2 btn btn-dark">
                            @lang('forms.send')
                        </button>
                    </div>
                </form>
            @endcan
        @endunless
        {{-- FILTERS --}}
        <div class="p-2 my-3 row" style="font-size: 1rem;">
            <div class="col-md-3">
            </div>
            <div class="form-group row col-md-5 offset-3">
                <div class="col-md-9 d-flex">
                    <label for="sortBy" class="fw-bold me-2" style="white-space: nowrap; font-size:1rem;">@lang('general.sort_by'):</label>
                    <select id="sortBy" class="form-select form-control" wire:model.change='sortBy.0'>
                        <option value="requested_at">@lang('modules.reports.requested_at')</option>
                        <option value="fullfilled_at">@lang('modules.reports.fullfilled_at')</option>
                        <option value="type">@lang('modules.reports.type')</option>
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
                    <div class="form-group">
                        <label for="typeFilter" class="mb-1 fw-bold">@lang('modules.reports.type')</label>
                        <select id="typeFilter" class="form-select form-control" wire:model.change='typeFilter'>
                            <option value="" {{ !$this->typeFilter ? 'selected' : '' }}>{{ App::isLocale('ar') ? 'الجميع' : 'All' }}</option>
                            <option value="transcript">@lang('modules.reports.transcript')</option>
                            <option value="registeration_proof">@lang('modules.reports.registeration_proof')</option>
                            <option value="re-garding">@lang('modules.reports.re-garding')</option>
                        </select>
                    </div>
                    <div class="mt-2 form-group">
                        <label for="fullfillFilter" class="mb-1 fw-bold">@lang('modules.reports.fullfilling')</label>
                        <select id="fullfillFilter" class="form-select form-control" wire:model.change='fullfillFilter'>
                            <option value="" {{ !$this->fullfillFilter ? 'selected' : '' }}>{{ App::isLocale('ar') ? 'الجميع' : 'All' }}</option>
                            <option value="fullfilled">@lang('modules.reports.fullfilled')</option>
                            <option value="not_fullfilled">@lang('modules.reports.not_fullfilled')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- /FILTERS --}}
        @if ($requests->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        @can('reports.requests.fullfilling')
                            <th>@lang('modules.students.name')</th>
                        @endcan
                        <th>@lang('modules.reports.type')</th>
                        <th>@lang('modules.reports.requested_at')</th>
                        <th>@lang('forms.notes')</th>
                        <th>@lang('modules.reports.fullfilled_at')</th>
                        <th>@lang('modules.reports.language')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr class="align-middle" wire:key='reports{{ $loop->iteration }}'>
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            @can('reports.requests.fullfilling')
                                <td>{{ $request->student->first_name . ' ' . $request->student->last_name }}</td>
                            @endcan
                            <td>{{ __("reports.$request->type") }}</td>
                            <td>{{ $request->requested_at }}</td>
                            <td>{{ Str::words($request->notes, 10, '...') }}</td>
                            <td>{{ $request->fullfilled_at ?: __('reports.not_fullfilled') }}</td>
                            <td>{{ $request->language == 'ar' ? 'العربية' : 'English' }}</td>
                            <td style="white-space: nowrap;">
                                @can('reports.request')
                                    <button class="btn btn-sm btn-danger"
                                        wire:confirm='Are you sure you want to delete this?'
                                        wire:click='delete("{{ $request->id }}")'
                                        >
                                            <i class="fa-solid fa-x"></i>
                                    </button>
                                @endcan
                                @can('reports.requests.fullfilling')
                                    {{-- <a href="{{ route() }}" class="btn btn-sm btn-primary">
                                        @lang('forms.fullfill')
                                    </a> --}}
                                    @switch($request->type)
                                        @case('transcript')
                                            <a href="{{ route('reports.transcript', ['studentId' => $request->student_id, 'lang' => $request->language]) }}" class="btn btn-sm btn-primary">
                                                @lang('modules.reports.print')
                                            </a>
                                            @break

                                        @default

                                    @endswitch
                                @endcan
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $requests->links() }}
    </div>

</x-page>
