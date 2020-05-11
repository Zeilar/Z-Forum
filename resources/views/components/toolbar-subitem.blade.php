<div class="toolbar-subitem">
    <h5 class="subitem-title">{{ $subitemTitle ?? '' }}</h5>
    <form @isset($formAction) action="{{$formAction}}" @endisset method="{{ $formMethod ?? 'post' }}" enctype="multipart/form-data">
        @csrf
        @isset($content)
            {{ $content }}
        @endisset
    </form>
</div>