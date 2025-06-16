@props(['icon', 'route'])

<li class="nav-item">
    <a href="{{ route($route) }}" class="nav-link {{ Route::is($route) ?  'active' : '' }}">
        <i class="{{ $icon }} nav-icon"></i>
        <p>@lang('sidebar.'.$route)</p>
    </a>
</li>
