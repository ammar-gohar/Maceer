<x-page title="sidebar.reports.docs_print" module="reports">

    <form wire:submit='print()'>
        <div class="card-body row">
            <div class="my-2">
                <label for="type">@lang('modules.students.name') *</label>
                <select name="type" id="type" wire:model.change='studentId' class="mt-2 form-select">
                    <option value="" {{ !$studentId ? 'selected' : ''}}></option>
                    @foreach ($students as $student)
                        <option value="{{ $student->national_id }}">{{ $student->student->academic_number }} - {{ $student->full_name }} ({{ $student->student->level->name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="my-2">
                <label for="type">@lang('modules.reports.type') *</label>
                <select name="type" id="type" wire:model.change='type' class="mt-2 form-select">
                    <option value="transcript">@lang('modules.reports.transcript')</option>
                    <option value="registeration_proof">@lang('modules.reports.registeration_proof')</option>
                    <option value="re-garding">@lang('modules.reports.re-garding')</option>
                </select>
            </div>
            <div class="my-2">
                <label for="type">@lang('modules.reports.concern')</label>
                <input type="text" id="concern" name="concern" wire:model.change='concern' class="mt-2 form-control">
            </div>
            <div class="my-2">
                <label for="type">@lang('forms.notes')</label>
                <textarea type="text" id="notes" name="notes" wire:model.change='notes' class="mt-2 form-control"></textarea>
            </div>
            <div class="my-2">
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
        </div>
        <div class="card-footer">
            <button type="submit" class="w-auto mt-2 btn btn-dark">
                <i class="fa-solid fa-print"></i> @lang('modules.reports.print')
            </button>
        </div>
    </form>
        {{-- /FILTERS --}}
</x-page>
