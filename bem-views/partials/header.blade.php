@if (isset($headerLayout['headers']) && is_array($headerLayout['headers']) && !empty($headerLayout['headers']))
    <header class="c-site-header">

        <div class="search-top {!! apply_filters('Municipio/desktop_menu_breakpoint','hidden-sm'); !!} hidden-print" id="search">
            <div class="container">
                <div class="grid">
                    <div class="grid-sm-12">
                        {{ get_search_form() }}
                    </div>
                </div>
            </div>
        </div>

        @foreach ($headerLayout['headers'] as $header)
            <div class="{{$header['class']}}">
                @if (isset($header['items']) && !empty($header['items']))
                    <div class="{{$header['rowClass']}}">

                        @foreach ($header['items'] as $item)
                            <div class="{{$item['class']}}">
                                <?php dynamic_sidebar($item['id']); ?>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        @endforeach

        <nav id="mobile-menu" class="nav-mobile-menu nav-toggle nav-toggle-expand {!! apply_filters('Municipio/mobile_menu_breakpoint','hidden-md hidden-lg'); !!} hidden-print">
            @include('partials.mobile-menu')
        </nav>

    </header>

@else
    @include('partials.notice',
        ['notice' =>
            ['class' => "info theme-admin-warning",
            'icon' => "pricon pricon-info-o",
            'text' => "You have not configured any header. You can add a header in the customizer."]
        ]
    )
@endif

@include('partials.hero')
