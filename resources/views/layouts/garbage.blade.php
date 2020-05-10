@extends('head')

@section('pageTitle')
    {{ __('Garbage') }}
@endsection

@section('content')
    <div id="garbage">
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