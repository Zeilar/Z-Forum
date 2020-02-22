<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<input type="hidden" name="_method" value="PUT" />
		<label class="file-upload" for="avatar-upload">
			<i class="fas color-white fa-upload"></i>
			{{ __('Choose a file') }}
		</label>
		<input type="file" id="avatar-upload" name="avatar" />
	</div>
	<button type="submit">Submit</button>
</form>