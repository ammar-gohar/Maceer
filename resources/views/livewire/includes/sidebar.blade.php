<!--begin::Sidebar-->
<aside class="shadow app-sidebar bg-info-subtle" data-bs-theme="dark">

    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">

      <!--begin::Brand Link-->
      <a href="./index.html" class="brand-link">

        <!--begin::Brand Image-->
        <img
          src="../../dist/assets/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="shadow opacity-75 brand-image"
        />
        <!--end::Brand Image-->

        <!--begin::Brand Text-->
        <span class="brand-text fw-light">Schoolary</span>
        <!--end::Brand Text-->

      </a>
      <!--end::Brand Link-->

    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">

        <!--begin::Sidebar Menu-->

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

        <<x-sidebar-list module="roles" icon="fa-gear" >
            <li class="nav-item">
                <a wire:navigate wire:click='showRolesTable()' class="nav-link {{ Route::is('roles.index') ?  'active' : '' }}">
                    <i class="fa-solid fa-gears nav-icon"></i>
                    <p>@lang('sidebar.roles.index')</p>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate wire:click='showRolesCreateForm()' class="nav-link {{ Route::is('roles.create') ?  'active' : '' }}">
                    <i class="fa-solid fa-plus nav-icon"></i>
                    <p>@lang('sidebar.roles.create')</p>
                </a>
            </li>
        </x-sidebar-list>

        <!--end::Sidebar Menu-->

      </nav>
    </div>
    <!--end::Sidebar Wrapper-->

</aside>
<!--end::Sidebar-->
