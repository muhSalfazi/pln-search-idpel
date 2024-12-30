<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @php
        use Illuminate\Support\Facades\Route;
    @endphp

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                @include('_partials.macros', ['height' => 20])
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ config('variables.templateName') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @php
            $showAdminSection = false;
        @endphp

        {{-- Loop pertama: Cek apakah ada menu admin yang bisa diakses --}}
        @foreach ($menuData[0]->menu as $menu)
            @if (isset($menu->slug) &&
                    in_array($menu->slug, ['users', 'pages-account-settings', 'auth']) &&
                    Auth::user()->role === 'admin')
                @php
                    $showAdminSection = true;
                    break;
                @endphp
            @endif
        @endforeach

        {{-- Loop kedua: Tampilkan header dan menu --}}
        @foreach ($menuData[0]->menu as $menu)
            {{-- Tampilkan header "Admin" hanya jika ada menu yang bisa diakses --}}
            @if (isset($menu->menuHeader) && $menu->menuHeader === 'Admin')
                @if ($showAdminSection)
                    <li class="menu-header mt-7">
                        <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                    </li>
                @endif
                @continue
            @endif

            {{-- Sembunyikan item admin seperti "Users" untuk non-admin --}}
            @if (isset($menu->slug) && in_array($menu->slug, ['users', 'auth']) && Auth::user()->role !== 'admin')
                @continue
            @endif

            @php
                $activeClass = null;
                $currentRouteName = Route::currentRouteName();

                if (isset($menu->slug) && $currentRouteName === $menu->slug) {
                    $activeClass = 'active';
                } elseif (isset($menu->submenu)) {
                    if (isset($menu->slug) && is_array($menu->slug)) {
                        foreach ($menu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                                $activeClass = 'active open';
                            }
                        }
                    } elseif (isset($menu->slug)) {
                        if (
                            str_contains($currentRouteName, $menu->slug) &&
                            strpos($currentRouteName, $menu->slug) === 0
                        ) {
                            $activeClass = 'active open';
                        }
                    }
                }
            @endphp

            {{-- Tampilkan item menu --}}
            <li class="menu-item {{ $activeClass }}">
                <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
                    @isset($menu->icon)
                        <i class="{{ $menu->icon }}"></i>
                    @endisset
                    <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                </a>

                {{-- Tampilkan submenu jika ada --}}
                @isset($menu->submenu)
                    @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                @endisset
            </li>
        @endforeach
    </ul>






</aside>
