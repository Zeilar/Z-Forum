@extends('head')

@section('pageTitle')
	{{ $message->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('message', $message) }}
@endsection

@section('content')
	@component('components.message', ['message' => $message, 'replyButton' => true])
        
    @endcomponent
@endsection