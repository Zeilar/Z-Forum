<div class="toolbar-row">
    <div class="toolbar-icon">
        @isset($icon)
            {!! $icon !!}
        @endisset
        <h5 class="toolbar-category" data-cookie="{{ $cookie ?? '' }}">{{ $categoryTitle ?? '' }}</h5>
    </div>
    <div class="toolbar-item">
        @isset($toolbarSubitem)
            {{ $toolbarSubitem }}
        @endisset
    </div>
</div>