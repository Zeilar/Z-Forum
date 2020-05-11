<div class="toolbar-subitem">
    <h4 class="subitem-title">{{ $subitemTitle ?? '' }}</h4>
    <form @isset($formAction) action="{{$formAction}}" @endisset method="{{ $formMethod ?? 'post' }}">
        @csrf
        @isset($content)
            {{ $content }}
        @endisset
    </form>
</div>