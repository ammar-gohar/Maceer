<x-page title="sidebar.reports.receipt_register" module="reports">

    <div class="card-body">
        @if ($receipts->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.students.academic_number')</th>
                        <th>@lang('modules.students.name')</th>
                        <th>@lang('modules.students.level')</th>
                        <th>@lang('modules.reports.paied_at')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr class="align-middle" wire:key='reports{{ $loop->iteration }}'>
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td>{{ $receipt->student->student->academic_number }}</td>
                            <td>{{ $receipt->student->first_name . ' ' . $receipt->student->last_name }}</td>
                            <td>{{ $receipt->student->student->level->name }}</td>
                            <td>{{ $receipt->paied_at ?: __('modules.reports.not_paied') }}</td>
                            <td>
                                @if ($receipt->paied_at)
                                    <button class="btn btn-sm btn-danger" wire:click='cancel_registeration("{{ $receipt->id }}")' wire:confirm>
                                        {{ App::isLocale('ar') ? 'إلغاء التسجيل' : 'Cancel Registeration' }}
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-primary" wire:click='open_to_register("{{ $receipt->id }}")'>
                                        {{ App::isLocale('ar') ? 'تسجيل' : 'Registeration' }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <hr>
        @if($toRegister)
            <table class="table mt-5 table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th>@lang('modules.students.academic_number')</th>
                        <th>@lang('modules.students.name')</th>
                        <th>@lang('modules.students.level')</th>
                        <th>@lang('modules.reports.total_cost')</th>
                        <th>@lang('modules.reports.receipt_number')</th>
                        <th>@lang('modules.reports.paied_at')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <td>{{ $toRegister->student->student->academic_number }}</td>
                        <td>{{ $toRegister->student->first_name . ' ' . $toRegister->student->last_name }}</td>
                        <td>{{ $toRegister->student->student->level->name }}</td>
                        <td>{{ $toRegister->total_cost }}</td>
                        <td>
                            <x-form-input name="receipt_number" type="number" wire_model="receipt_number" required="required" span="12" label=''/>
                            @error('receipt_number')
                                <span class="text text-danger">* {{ $message }}</span>
                            @enderror
                        </td>
                        <td>
                            <x-form-input name="paied_at" type="date" wire_model="paied_at" required="required" span="12" label=''/>
                            @error('paied_at')
                                <span class="text text-danger">* {{ $message }}</span>
                            @enderror
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark" type="submit" wire:click='register_receipt()'>
                                @lang('forms.save')
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endIf
    </div>
    <!-- /.card-body -->

</x-page>
