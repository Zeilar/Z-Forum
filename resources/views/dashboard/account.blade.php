<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="img">Select image:</label>
		<input type="hidden" name="_method" value="PUT" />
		<input type="file" id="img" name="img" />
	</div>
	<button type="submit">Submit</button>
</form>