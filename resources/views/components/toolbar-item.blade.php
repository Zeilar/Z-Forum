<div class="toolbar-row">
    <div class="toolbar-icon">
        @isset($icon)
            {{ $icon }}
        @endisset
        <h4 class="toolbar-category">{{ $categoryTitle ?? '' }}</h4>
    </div>
    <div class="toolbar-item">
        <div class="toolbar-subitem maintenance-mode">
            <h5 class="subitem-title">{{ $subitemTitle ?? '' }}</h5>
            <form action="{{ $formAction ?? '' }}" method="{{ $formMethod ?? 'post' }}">
                @csrf
                @isset($content)
                    {{ $content }}
                @endisset
            </form>
        </div>
    </div>
</div>