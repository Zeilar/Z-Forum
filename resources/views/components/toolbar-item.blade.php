@if (isset($cookie) && isset($_COOKIE['toolbarItemOpen']) && $_COOKIE['toolbarItemOpen'] === $cookie)
    @php $match = true @endphp
@endif

<div class="toolbar-row">
    <div class="toolbar-icon @isset($match) active @endisset">
        @isset($icon)
            {!! $icon !!}
        @endisset
        <h5 class="toolbar-category" data-cookie="{{ $cookie ?? '' }}">{{ $categoryTitle ?? '' }}</h5>
    </div>
    <div class="toolbar-item @isset($match) show @endisset">
        @isset($toolbarSubitem)
            {{ $toolbarSubitem }}
        @endisset
    </div>
</div>