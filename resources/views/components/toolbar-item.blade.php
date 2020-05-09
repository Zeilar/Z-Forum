<div class="toolbar-row">
    <div class="toolbar-icon @if($cookie !== null && $_COOKIE['toolbarItemOpen'] === $cookie) active @endif">
        @isset($icon)
            {!! $icon !!}
        @endisset
        <h5 class="toolbar-category" data-cookie="{{ $cookie ?? '' }}">{{ $categoryTitle ?? '' }}</h5>
    </div>
    <div class="toolbar-item @if($cookie !== null && $_COOKIE['toolbarItemOpen'] === $cookie) show @endif">
        @isset($toolbarSubitem)
            {{ $toolbarSubitem }}
        @endisset
    </div>
</div>