<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center col-md-6 fs-4 fw-bold">@lang('modules.reports.generate_exam_schedule')</div>
    </div>
    <!--end::Header-->
    <div class="card-body" style="overflow-x: scroll;">

        @if ($files)
            <div>
                <div class="alert alert-success">
                    @lang('modules.reports.exam_schedule_generated')
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <button wire:click='download("zip")' class="btn btn-dark">
                        <i class="bi bi-download"></i> @lang('modules.reports.download_schedule_zip')
                    </button>
                    <button wire:click='download("csv")' class="btn btn-primary">
                        <i class="bi bi-download"></i> @lang('modules.reports.download_csv')
                    </button>
                    <button type="button" wire:click='new_schedule()' class="btn btn-success">
                        <i class="bi bi-plus"></i> @lang('modules.reports.generate_new')
                    </button>
                </div>
            </div>
        @else
            <form wire:submit='generate_exam'>
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <x-form-input name="start_date" label="Start Date" wire_model="start_date" type="date" span="6" />
                        <!--end::Col-->

                        <!--begin::Col-->
                        <x-form-input name="end_date" label="End Date" wire_model="end_date" type="date" span="6" />
                        <!--end::Col-->

                        <!--begin::Col-->
                        <x-form-input name="schedules_number" label="Schedules Number" wire_model="schedules_number" type="number" min="0" span="6" />
                        <!--end::Col-->

                        <!--begin::Col-->
                        <x-form-input name="csv" label="CSV file" wire_model="csv" type="file" min="0" span="6" accept=".csv" required=""/>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <div class="my-2 form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" id="includeFridays" wire:model.change="include_fridays">
                                <label class="form-check-label" for="includeFridays">
                                    @lang('forms.include_fridays')
                                </label>
                            </div>
                            @error('include_fridays')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <div class="my-2 form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" id="includegraphs" wire:model.change="include_graphs">
                                <label class="form-check-label" for="includegraphs">
                                    @lang('forms.include_graphs')
                                </label>
                            </div>
                            <small>@lang('forms.include_graphs_info')</small>
                            @error('include_graphs')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-12">
                            <label class="form-label">@lang('modules.reports.holiday_dates')</label>
                            @foreach ($holidays as $index => $holiday)
                                <div class="mb-2 input-group">
                                    <input type="date" class="form-control" wire:model.blur="holidays.{{ $index }}">
                                    <button class="btn btn-danger" type="button" wire:click="removeHoliday({{ $index }})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                @error("holidays.$index")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            @endforeach
                            <button type="button" class="mt-2 btn btn-light btn-sm" wire:click="addHoliday">
                                <i class="bi bi-plus-circle"></i> @lang('modules.reports.add_holiday')
                            </button>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="mt-3 card-footer">
                    <button type="submit" class="btn btn-dark" wire:loading.attr='disabled' wire:target='generate_exam'>
                        <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='generate_exam'>
                            <span class="text-sm visually-hidden"></span>
                        </div>
                        <span wire:loading wire:target='generate_exam'>@lang('forms.generating')</span>
                        <span wire:loading.remove wire:target='generate_exam'>@lang('forms.generate')</span>
                    </button>

                    <button type="reset" class="border btn btn-light">@lang('forms.reset')</button>
                </div>
                <!--end::Footer-->
            </form>
        @endunless

    </div>
    <!-- /.card-body -->

</div>
