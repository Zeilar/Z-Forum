@extends('head')

@section('pageTitle')
    {{ __('Garbage') }}
@endsection

@section('content')
    <div id="garbage">
        @if (!count($subcategories) && !count($chat_messages) && !count($user_messages) && !count($categories) && !count($threads) && !count($posts))
            <h2 class="garbage-empty">{{ __('The garbage can is empty') }}</h2>
        @endif
    
        @foreach($posts as $post)
            @component('components.post', [
                'post'				   => $post,
                'disablePostToolbar'   => true,
                'disablePostBanner'    => true,
                'disablePostSignature' => true,
                'deleted'              => true,
            ])  
            @endcomponent
        @endforeach
    </div>
@endsection