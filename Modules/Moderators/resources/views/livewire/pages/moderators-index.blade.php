<x-page title="sidebar.moderators.index" module="moderators" ::show_delete_button="true">

    <div class="card-body">
        @if ($moderators->count() > 0)
            <table class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('forms.name')</th>
                        <th>@lang('forms.gender')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moderators as $moderator)
                        <livewire:moderators::moderator-list :moderator="$moderator" wire:key='{{ $moderator->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-secondary fw-none">
                <h3 class="my-0 fw-normal">@lang('modules.moderators.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $moderators->links() }}
    </div>

</x-page>
