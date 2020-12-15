<header id="site-header" style="overflow-x: hidden;">

    {{-- NAVIGATION PRIMARY NAV --}}
    @includeIf('partials.navigation.primary')

    {{-- NAVIGATION MOBILE NAV --}}
    @includeIf('partials.navigation.mobile')

    {{-- NAVIGATION HELPER NAV --}}
    @includeIf('partials.navigation.helper')

    {{-- After header body --}}
    @yield('after-header-body')

</header>

@includeIf('partials.navigation.helper')

@includeIf('partials.hero')

@includeIf('partials.sidebar', ['id' => 'top-sidebar'])