<div class="toolbar-subitem maintenance-mode">
    <h5 class="subitem-title">{{ $subitemTitle ?? '' }}</h5>
    <form action="{{ $formAction ?? '' }}" method="{{ $formMethod ?? 'post' }}">
        @csrf
        @isset($content)
            {{ $content }}
        @endisset
    </form>
</div>