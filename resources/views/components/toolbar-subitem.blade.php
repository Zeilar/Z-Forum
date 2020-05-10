<div class="toolbar-subitem">
    <h5 class="subitem-title">{{ $subitemTitle ?? '' }}</h5>
    <form @isset($formAction) action="{{$formAction}}" @endisset method="{{ $formMethod ?? 'post' }}">
        @csrf
        @isset($content)
            {{ $content }}
        @endisset
    </form>
</div>