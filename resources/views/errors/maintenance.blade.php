@extends('head')

@section('pageTitle')
    {{ __('Maintenance') }}
@endsection

@php
    $disableNavbar = true;
    $disableSidebar = true;
    $disableModals = true;
@endphp

@section('content')
    @empty($disableMaintenance)
        <div id="maintenance">
            <h1>{{ __('We are in maintenance') }}</h1>
            <h2>{{ __('Surf back at a later date!') }}</h2>
        </div>
    @endempty
@endsection