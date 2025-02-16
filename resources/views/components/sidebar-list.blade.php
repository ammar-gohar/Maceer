@props(['module', 'icon'])

<ul
    class="nav sidebar-menu flex-column {{ Route::is($module.'.*') ? 'active' : '' }}"
    data-lte-toggle="treeview"
    role="menu"
    data-accordion="false"
>
    <li class="nav-item {{ Route::is($module.'.*') ? 'menu-open' : '' }}">
        <a class="nav-link" style="cursor: pointer;">
            <i class="fa-solid {{ $icon }} nav-icon"></i>
            <p>
                @lang('sidebar.'.$module.'.title')
                <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ps-3" @style(['display: none;' => !Route::is($module.'.*')])>

            {{ $slot }}

        </ul>
    </li>
</ul>
