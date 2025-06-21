<x-page title="modules.roles.index" module="roles">

    <div class="card-body">
        <table class="table table-bordered table-striped" style="overflow-x: scroll;">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>@lang('modules.roles.title')</th>
                    <th>@lang('modules.roles.permissions_number')</th>
                    <th>@lang('modules.roles.users_number')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <livewire:roles::roles-item :role="$role" :iteration="$loop->iteration" wire:key='{{ $role->id }}'>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $roles->links() }}
    </div>

</x-page>
