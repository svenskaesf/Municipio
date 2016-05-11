<header id="site-header" class="site-header {{ $headerLayout['class'] }}">
    <div class="print-only container">
        <div class="grid">
            <div class="grid-sm-12">
                {!! municipio_get_logotype('standard') !!}
            </div>
        </div>
    </div>

        @include('partials.header.' . $headerLayout['template'])
    @endif
</header>

@include('partials.hero')
