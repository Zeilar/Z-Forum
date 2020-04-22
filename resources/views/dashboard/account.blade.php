@extends('head')

@section('pageTitle')
	{{ __('Settings') }}
@endsection

@section('content')
	<div id="settings">
		<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="_method" value="PUT" />

			<div class="form-group">
				<p>{{ __('Avatar') }}</p>

				<label class="file-upload" for="avatar-upload">
					<i class="fas color-white fa-upload"></i>
					<span>{{ __('Upload file') }}</span>
				</label>
				<input type="file" id="avatar-upload" name="user-avatar" />
			</div>

			<div class="form-group">
				<label for="settings-email">Email address</label>
    			<input type="email" class="form-control" id="settings-email" placeholder="{{$user->email}}">
			</div>

			<button type="submit">Submit</button>
		</form>
	</div>
	<script>
		$('.nav-link.account').parent().append('<div class="nav-ruler"></div>');
		$('.nav-link.account').addClass('active');
	</script>
@endsection