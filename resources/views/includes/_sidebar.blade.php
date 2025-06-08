<!--begin::Sidebar-->
<aside class="shadow app-sidebar bg-dark" data-bs-theme="dark">

    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">

      <!--begin::Brand Link-->
      <a href="{{ route('home') }}" class="brand-link">

        <!--begin::Brand Image-->
        {{-- <img
          src="../../dist/assets/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="shadow opacity-75 brand-image"
        /> --}}
        <!--end::Brand Image-->

        <!--begin::Brand Text-->
        <span class="brand-text fw-bold fs-4">{{ App::isLocale('ar') ? 'مَسير' : 'Maceer' }}</span>
        <!--end::Brand Text-->

      </a>
      <!--end::Brand Link-->

    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="false">

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>@lang('general.home')</p>
                    </a>
                </li>

            </ul>
        <!--begin::Sidebar Menu-->
        @can('semseter.settings')
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="false">

                <li class="nav-item">
                    <a href="{{ route('semester') }}" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>@lang('sidebar.semester')</p>
                    </a>
                </li>

            </ul>
        @endcan

        {{-- @can('semseter.settings') --}}
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="false">

                <li class="nav-item">
                    <a href="{{ route('quizzes.index-student') }}" class="nav-link">
                        <i class="nav-icon fa fa-file-pen"></i>
                        <p>@lang('sidebar.quizzes.index-student')</p>
                    </a>
                </li>

            </ul>
        {{-- @endcan --}}

            @canany(['admins.index', 'admins.create'])
                {{-- Admin sidebar --}}
                <x-sidebar-list module="admins" icon="fa-user-tie">
                    @can('admins.index')
                        <x-sidebar-item icon="fa-user-group" route="admins.index" />
                    @endcan
                    @can('admins.create')
                        <x-sidebar-item icon="fa-user-plus" route="admins.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::admins sidebar --}}
            @endcan

            @canany(['moderators.index', 'moderators.create'])
                {{-- Moderators sidebar --}}
                <x-sidebar-list module="moderators" icon="fa-user-gear">
                    @can('moderators.index')
                        <x-sidebar-item icon="fa-user-group" route="moderators.index" />
                    @endcan
                    @can('moderators.create')
                        <x-sidebar-item icon="fa-user-plus" route="moderators.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::moderators sidebar --}}
            @endcan

            @canany(['professors.index', 'professors.create'])
                {{-- Professors sidebar --}}
                <x-sidebar-list module="professors" icon="fa-chalkboard-user">
                    @can('professors.index')
                        <x-sidebar-item icon="fa-user-group" route="professors.index" />
                    @endcan
                    @can('professors.create')
                        <x-sidebar-item icon="fa-user-plus" route="professors.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Professors sidebar --}}
            @endcan

            @canany(['students.index', 'students.create'])
                {{-- Students sidebar --}}
                <x-sidebar-list module="students" icon="fa-user-graduate">
                    @can('students.index')
                        <x-sidebar-item icon="fa-user-group" route="students.index" />
                    @endcan
                    @can('students.create')
                        <x-sidebar-item icon="fa-user-plus" route="students.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::sutdents sidebar --}}
            @endcan

            @canany(['roles.index', 'roles.create'])
                {{-- Roles sidebar --}}
                <x-sidebar-list module="roles" icon="fa-gear">
                    @can('roles.index')
                        <x-sidebar-item icon="fa-gears" route="roles.index" />
                    @endcan
                    @can('roles.create')
                        <x-sidebar-item icon="fa-plus" route="roles.create" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Roles sidebar --}}
            @endcan

            @canany(['courses.index', 'courses.create', 'courses.requests', 'courses.schedule', 'courses.my-courses'])
                {{-- Courses sidebar --}}
                <x-sidebar-list module="courses" icon="fa-book-open">
                    @can('courses.index')
                        <x-sidebar-item icon="fa-list" route="courses.index" />
                    @endcan
                    @can('courses.create')
                        <x-sidebar-item icon="fa-plus" route="courses.create" />
                    @endcan
                    @can('courses.requests')
                        <x-sidebar-item icon="fa-list" route="courses.requests" />
                    @endcan
                    @can('courses.schedule')
                        <x-sidebar-item icon="fa-calendar-days" route="courses.schedule" />
                    @endcan
                    @can('courses.student-schedule')
                        <x-sidebar-item icon="fa-calendar-days" route="courses.student-schedule" />
                    @endcan
                    @can('courses.student.show')
                        <x-sidebar-item icon="fa-list" route="courses.student-show" />
                    @endcan
                    @can('courses.professor.show')
                        <x-sidebar-item icon="fa-list" route="courses.professor-show" />
                    @endcan
                </x-sidebar-list>
                {{-- end::Courses sidebar --}}
            @endcan

            @canany(['halls.index', 'halls.create'])
                {{-- Halls sidebar --}}
                <x-sidebar-list module="halls" icon="fa-chalkboard">
                    @can('halls.index')
                        <x-sidebar-item icon="fa-list" route="halls.index" />
                    @endcan
                    @can('halls.create')
                        <x-sidebar-item icon="fa-plus" route="halls.create" />
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
