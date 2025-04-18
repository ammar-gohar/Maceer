<x-page title="sidebar.semester">


    @if ($current)
        <div class="card-body">
            <!--begin::Row-->
            <h3 class="mb-3 alert alert-info">
                @lang('forms.semester_active', ['date' => $current->end_date])
            </h3>
            <h5 class="mb-3">
                @lang('forms.want_end_semester')
            </h5>
            <button type="button" class="btn btn-danger" wire:click='end_semester("{{ $current->id }}")' wire:confirm>
                @lang('forms.end_semester')
            </button>
        </div>
    @else
        <form wire:submit='start_semester()'>
            <div class="card-body">
                <!--begin::Row-->
                <div class="row g-3">
                    <x-form-input name="name" wire_model="name" span="12"/>
                    <x-form-input name="start_date" type="date" wire_model="start_date" />
                    <x-form-input name="end_date" type="date" wire_model="end_date" />
                </div>
            </div>

            <!--begin::Footer-->
            <div class="mt-3 card-footer">
                <button type="submit" class="btn btn-dark" type="submit" wire:loading.attr='disabled' wire:target='start_semester'>
                    <div class="mx-2 spinner-border spinner-border-sm" role="status" wire:loading wire:target='add_course'>
                        <span class="text-sm visually-hidden"></span>
                    </div>
                    <span>@lang('forms.start_semester')</span>
                </button>
                <button type="reset" class="border btn btn-light" wire:click='reset()'>@lang('forms.reset')</button>
            </div>
            <!--end::Footer-->
        </form>

    @endif

</x-page>
