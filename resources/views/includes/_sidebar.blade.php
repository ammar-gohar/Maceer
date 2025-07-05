<!--begin::Sidebar-->
<aside class="shadow app-sidebar bg-dark" data-bs-theme="dark">

    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">

      <!--begin::Brand Link-->
      <a href="{{ route('home') }}" class="brand-link">

        <!--begin::Brand Image-->
        <img
          src="{{ asset('favicon_light.png') }}"
          alt="Maceer logo"
          class="shadow opacity-75 brand-image"
          style="max-height: 40px"
        />
        <!--end::Brand Image-->

        <!--begin::Brand Text-->
        <span class="brand-text fw-bold fs-4 ms-0">{{ App::isLocale('ar') ? 'مَسير' : 'Maceer' }}</span>
        <!--end::Brand Text-->

      </a>
      <!--end::Brand Link-->

    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>@lang('general.home')</p>
                    </a>
                </li>

            </ul>
        <!--begin::Sidebar Menu-->
        @can('semseter.settings')
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('semester') }}" class="nav-link {{ Route::is('semester') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-calendar-gear"></i>
                        <p>@lang('sidebar.semester')</p>
                    </a>
                </li>

            </ul>
        @endcan

        @if (!Auth::user()->hasRole('Super Admin'))
            @can('quizzes.index-student')
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                    <li class="nav-item">
                        <a href="{{ route('quizzes.index-student') }}" class="nav-link {{ Route::is('quizzes.index-student') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa fa-file-pen"></i>
                            <p>@lang('sidebar.quizzes.index-student')</p>
                        </a>
                    </li>

                </ul>
            @endcan
        @endif

        @canany(['reports.request', 'reports.requests.fullfilling'])
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('docs.index') }}" class="nav-link {{ Route::is('docs.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file-chart-column"></i>
                        <p>@lang('sidebar.reports.index')</p>
                    </a>
                </li>

            </ul>
        @endcan

        @canany(['reports.requests.fullfilling'])
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('docs.create') }}" class="nav-link {{ Route::is('docs.create') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file-chart-column"></i>
                        <p>@lang('sidebar.reports.docs_print')</p>
                    </a>
                </li>

            </ul>
        @endcan

        @canany(['reports.receipt', 'reports.receipts.register'])
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                @can('reports.receipts.register')
                    <li class="nav-item">
                        <a href="{{ route('receipt.register') }}" class="nav-link {{ Route::is('receipt.register') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-chart-column"></i>
                            <p>@lang('sidebar.reports.receipt_register')</p>
                        </a>
                    </li>
                @else
                    {{-- <li class="nav-item">
                        <a href="{{ route('receipt.show') }}" class="nav-link {{ Route::is('receipt.show') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-chart-column"></i>
                            <p>@lang('sidebar.reports.receipt_show')</p>
                        </a>
                    </li> --}}
                @endcan

            </ul>
        @endcan

        @can('semseter.settings')
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('exam.schedule.generate') }}" class="nav-link {{ Route::is('exam.schedule.generate') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa fa-file-pen"></i>
                        <p>@lang('sidebar.exam_schedule_generate')</p>
                    </a>
                </li>

            </ul>
        @endcan

        @can('courses.enrollment')
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="fa-solid false">

                <li class="nav-item">
                    <a href="{{ route('gpa.calculator') }}" class="nav-link {{ Route::is('gpa.calculator') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa fa-file-pen"></i>
                        <p>@lang('modules.reports.gpa_calculator')</p>
                    </a>
                </li>

            </ul>
        @endcan

            @canany(['moderators.index', 'moderators.create'])
                {{-- Moderators sidebar --}}
                <x-sidebar-list module="moderators" icon="fa-solid fa-user-gear">
                    @can('moderators.index')
                        <x-sidebar-item icon="fa-solid fa-user-group" route="moderators.index" />
                    @endcan
                    @can('moderators.create')
                        <x-sidebar-item icon="fa-solid fa-user-plus" route="moderators.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::moderators sidebar --}}
            @endcan

            @canany(['professors.index', 'professors.create'])
                {{-- Professors sidebar --}}
                <x-sidebar-list module="professors" icon="fa-solid fa-chalkboard-user">
                    @can('professors.index')
                        <x-sidebar-item icon="fa-solid fa-user-group" route="professors.index" />
                    @endcan
                    @can('professors.create')
                        <x-sidebar-item icon="fa-solid fa-user-plus" route="professors.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Professors sidebar --}}
            @endcan

            @canany(['students.index', 'students.create', 'students.guidence'])
                {{-- Students sidebar --}}
                <x-sidebar-list module="students" icon="fa-solid fa-user-graduate">
                    @can('students.index')
                        <x-sidebar-item icon="fa-solid fa-user-group" route="students.index" />
                    @endcan
                    @can('students.create')
                        <x-sidebar-item icon="fa-solid fa-user-plus" route="students.create" />
                    @endcan
                    @unless ((Auth::user()->professor && !Auth::user()->professor->is_guide))
                        @can('students.guidence')
                            <x-sidebar-item icon="fa-solid fa-user-plus" route="students.guidence" />
                        @endcan
                    @endunless
                </x-sidebar-list>
                {{-- end::sutdents sidebar --}}
            @endcan

            @canany(['roles.index', 'roles.create'])
                {{-- Roles sidebar --}}
                <x-sidebar-list module="roles" icon="fa-solid fa-gear">
                    @can('roles.index')
                        <x-sidebar-item icon="fa-solid fa-gears" route="roles.index" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Roles sidebar --}}
            @endcan

            @canany(['courses.index', 'courses.create', 'courses.requests', 'schedule.index', 'courses.my-courses', 'courses.enrollment', 'courses.professor.show', 'courses.student-schedule'])
                {{-- Courses sidebar --}}
                <x-sidebar-list module="courses" icon="fa-solid fa-book-open">
                    @can('courses.index')
                        <x-sidebar-item icon="fa-solid fa-list" route="courses.index" />
                    @endcan
                    @can('courses.create')
                        <x-sidebar-item icon="fa-solid fa-plus" route="courses.create" />
                    @endcan
                    @can('courses.requests-stats')
                        <x-sidebar-item icon="fa-solid fa-list" route="courses.requests-stats" />
                    @endcan
                    @can('schedule.index')
                        <x-sidebar-item icon="fa-solid fa-calendar-days" route="courses.schedule" />
                    @endcan
                    @canany(['schedule.index', 'courses.student-schedule'])
                        <x-sidebar-item icon="fa-solid fa-calendar-days" route="courses.schedule-list" />
                    @endcan
                    @can('courses.enrollment')
                        @unless (Auth::user()->hasRole('Super Admin'))
                            <x-sidebar-item icon="fa-solid fa-list" route="courses.requests" />
                            <x-sidebar-item icon="fa-solid fa-calendar-check" route="courses.student-schedule" />
                            <x-sidebar-item icon="fa-solid fa-list" route="students.enrollments" />
                            <x-sidebar-item icon="fa-solid fa-list" route="courses.student-show" />
                        @endunless
                    @endcan
                    @can('courses.professor.show')
                        <x-sidebar-item icon="fa-solid fa-list" route="courses.professor-show" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Courses sidebar --}}
            @endcan

            @canany(['halls.index', 'halls.create'])
                {{-- Halls sidebar --}}
                <x-sidebar-list module="halls" icon="fa-solid fa-chalkboard">
                    @can('halls.index')
                        <x-sidebar-item icon="fa-solid fa-list" route="halls.index" />
                    @endcan
                    @can('halls.create')
                        <x-sidebar-item icon="fa-solid fa-plus" route="halls.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Halls sidebar --}}
            @endcan

        <!--end::Sidebar Menu-->

      </nav>
    </div>
    <!--end::Sidebar Wrapper-->

  </aside>
<!--end::Sidebar-->
