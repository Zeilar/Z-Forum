<div class="toolbar-row">
    <div class="toolbar-icon">
        @isset($icon)
            {{ $icon }}
        @endisset
        <h4 class="toolbar-category">{{ $categoryTitle ?? '' }}</h4>
    </div>
    <div class="toolbar-item">
        @isset($toolbarSubitem)
            {{ $toolbarSubitem }}
        @endisset
    </div>
</div>