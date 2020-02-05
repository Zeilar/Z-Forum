@extends('layouts.head')

@section('content')
	<?php $role = strtolower(Auth::user()->role); ?>
	@include("layouts.user.$role")
@endsection