@extends('layouts.head')

@section('content')
	@component('components.dashboard')
		@section('dashboard-settings')
			<div class="wrapper d-flex h-100" id="superadmin">
				<div class="row w-100">
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Table categories') }}</p>
							<form action="" method="post">
								<select class="form-control">
									@foreach ($tableCategories as $tableCategory)
										<option>{{ __($tableCategory->title) }}</option>
									@endforeach
								</select>
							</form>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Table subcategories') }}</p>
							<form action="" method="post">
								<select class="form-control">
									@foreach ($tableSubcategories as $tableSubcategory)
										<option>{{ __($tableSubcategory->title) }}</option>
									@endforeach
								</select>
							</form>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Threads') }}</p>
							<form action="" method="post">
								<select class="form-control">
									@foreach ($threads as $thread)
										<option>{{ $thread->title }}</option>
									@endforeach
								</select>
							</form>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Posts') }}</p>
							<form action="" method="post">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<select class="form-control">
									@foreach ($posts as $post)
										<option value="{{$post->id}}">{{ $post->id }}</option>
									@endforeach
								</select>
								<a href="">
									<button class="btn btn-primary" type="button">{{ __('View') }}</button>
								</a>
								<a href="">
									<button class="btn btn-success" type="button">{{ __('Edit') }}</button>
								</a>
								<button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
							</form>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Users') }}</p>
							<form action="" method="post">
								<select class="form-control">
									@foreach ($users as $user)
										<option>{{ $user->username }}</option>
									@endforeach
								</select>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endsection
	@endcomponent
@endsection

<script
	src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
	integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
	crossorigin="anonymous">
</script>

<script>

$('#superadmin select').change(function() {
	$(this).children().each(function() {
		if ($(this)[0].selected) {
			let that = $(this);
			$.ajax({
				url: "{!!url()->current()!!}",
				dataType: "json",
				success: function(html) {
					that.val(html.data.test);
					console.log('success');
				}
			});
		}
	});
});

</script>