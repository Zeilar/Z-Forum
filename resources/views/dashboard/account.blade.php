@extends('layouts.head')

@section('content')
	<div id="settings">
		<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<input type="hidden" name="_method" value="PUT" />
				<label class="file-upload" for="avatar-upload">
					<i class="fas color-white fa-upload"></i>
					<span>{{ __('Choose a file') }}</span>
				</label>
				<input type="file" id="avatar-upload" name="avatar" />
			</div>
			<button type="submit">Submit</button>
		</form>
	</div>
	<script>
		$('.nav-link.account').addClass('color-white');
		$('.nav-link.account').parent().append('<div class="nav-ruler"></div>');
	</script>
@endsection