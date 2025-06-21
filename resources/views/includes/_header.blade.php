<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">

    <!--begin::Container-->
    <div class="container-fluid">

      <!--begin::Start Navbar Links-->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-lte-toggle="sidebar" role="button">
            <i class="bi bi-list"></i>
          </a>
        </li>
        <li class="nav-item d-none d-md-block"><a href="{{ route('home') }}" class="nav-link">@lang('general.home')</a></li>
      </ul>
      <!--end::Start Navbar Links-->

      <!--begin::End Navbar Links-->
      <ul class="navbar-nav ms-auto">

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="mx-2">@lang('general.lang')</span><i class="bi bi-globe2"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item @if(App::isLocale('ar')) bg-secondary-subtle @endif" href="/language/ar">العربية</a>
                </li>
                <li>
                    <a class="dropdown-item @if(App::isLocale('en')) bg-secondary-subtle @endif" href="/language/en">English</a>
                </li>
            </ul>
        </div>

        <!--begin::Fullscreen Toggle-->
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
          </a>
        </li>
        <!--end::Fullscreen Toggle-->

        <!--begin::User Menu Dropdown-->
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img
              src="../../dist/assets/img/user2-160x160.jpg"
              class="shadow user-image rounded-circle"
              alt="User Image"
            />
            <span class="d-none d-md-inline">{{ Auth::user()->full_name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

            <!--begin::User Image-->
            <li class="user-header text-bg-dark">

              <img
                src="../../dist/assets/img/user2-160x160.jpg"
                class="shadow rounded-circle"
                alt="User Image"
              />

              <p>
                {{ Auth::user()->full_name }}
                <small>{{ App::isLocale('ar') ? Auth::user()->roles->first()->name_ar : Auth::user()->roles->first()->name }}</small>
              </p>
            </li>
            <!--end::User Image-->

            <!--begin::Menu Footer-->
            <li class="user-footer">
                <a class="btn btn-secondary btn-flat">@lang('general.profile')</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-default btn-flat float-end d-inline">@lang('general.logout')</button>
                </form>
            </li>
            <!--end::Menu Footer-->

          </ul>
        </li>
        <!--end::User Menu Dropdown-->
      </ul>
      <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
