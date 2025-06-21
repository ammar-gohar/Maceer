<x-page title="sidebar.professors.index" module="professors" show_create_button="true">

    <div class="card-body">
        @if ($professors->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.professors.name')</th>
                        <th>@lang('modules.professors.gender')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professors as $professor)
                        <livewire:professors::professors-list :professor="$professor" wire:key='{{ $professor->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.professors.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $professors->links() }}
    </div>

</x-page>
