<x-page title="sidebar.students.index" module="students" show-create-button="true">

    <div class="card-body">
        @if ($students->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>@lang('modules.students.name')</th>
                        <th>@lang('modules.students.gender')</th>
                        <th>@lang('modules.students.level')</th>
                        <th>@lang('modules.students.credits')</th>
                        <th>@lang('modules.students.gpa')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <livewire:students::student-list :student="$student" wire:key='{{ $student->id }}' :loop="$loop"/>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-warning">
                <h3>@lang('modules.students.empty')</h3>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="clearfix card-footer">
        {{ $students->links() }}
    </div>

</x-page>
