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

        <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-according="false">

            <li class="nav-item">
                <a href="{{ route('semester') }}" class="nav-link">
                    <i class="nav-icon bi bi-palette"></i>
                    <p>@lang('sidebar.semester')</p>
                </a>
            </li>

        </ul>

            {{-- Admin sidebar --}}
            <x-sidebar-list module="admins" icon="fa-user-tie">
                <x-sidebar-item icon="fa-user-group" route="admins.index" />
                <x-sidebar-item icon="fa-user-plus" route="admins.create" />
            </x-sidebar-list>
            {{-- end::admins sidebar --}}

            {{-- Moderators sidebar --}}
            <x-sidebar-list module="moderators" icon="fa-user-gear">
                <x-sidebar-item icon="fa-user-group" route="moderators.index" />
                <x-sidebar-item icon="fa-user-plus" route="moderators.create" />
            </x-sidebar-list>
            {{-- end::moderators sidebar --}}

            {{-- Professors sidebar --}}
            <x-sidebar-list module="professors" icon="fa-chalkboard-user">
                <x-sidebar-item icon="fa-user-group" route="professors.index" />
                <x-sidebar-item icon="fa-user-plus" route="professors.create" />
            </x-sidebar-list>
            {{-- end::Professors sidebar --}}

            {{-- Students sidebar --}}
            <x-sidebar-list module="students" icon="fa-user-graduate">
                <x-sidebar-item icon="fa-user-group" route="students.index" />
                <x-sidebar-item icon="fa-user-plus" route="students.create" />
            </x-sidebar-list>
            {{-- end::sutdents sidebar --}}

            {{-- Roles sidebar --}}
            <x-sidebar-list module="roles" icon="fa-gear">
                <x-sidebar-item icon="fa-gears" route="roles.index" />
                <x-sidebar-item icon="fa-plus" route="roles.create" />
            </x-sidebar-list>
            {{-- end::Roles sidebar --}}

            {{-- Courses sidebar --}}
            <x-sidebar-list module="courses" icon="fa-book-open">
                <x-sidebar-item icon="fa-list" route="courses.index" />
                <x-sidebar-item icon="fa-plus" route="courses.create" />
                <x-sidebar-item icon="fa-calendar-days" route="courses.schedule" />
            </x-sidebar-list>
            {{-- end::Courses sidebar --}}

            {{-- Halls sidebar --}}
            <x-sidebar-list module="halls" icon="fa-chalkboard">
                <x-sidebar-item icon="fa-list" route="halls.index" />
                <x-sidebar-item icon="fa-plus" route="halls.create" />
            </x-sidebar-list>
            {{-- end::Halls sidebar --}}

        <!--end::Sidebar Menu-->

      </nav>
    </div>
    <!--end::Sidebar Wrapper-->

  </aside>
<!--end::Sidebar-->
