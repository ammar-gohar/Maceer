<div class="mx-auto my-4 card" style="width: 90%;">
    <div class="card-header"><h3 class="card-title">@lang('sidebar.roles.index')</h3></div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered">
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
    {{ $roles->links() }}
    {{-- <div class="clearfix card-footer">
        <ul class="m-0 pagination pagination-sm float-end">
        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div> --}}
</div>
<!-- /.card -->
