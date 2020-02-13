@extends('layouts.head')

@section('content')
	@component('components.dashboard')
		@section('dashboard-settings')
			<div class="wrapper d-flex h-100" id="superadmin">
				<div class="row w-100">
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Table categories') }}</p>
							<select multiple class="form-control">
								@foreach ($tableCategories as $tableCategory)
									<option>{{ __($tableCategory->title) }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Table subcategories') }}</p>
							<select multiple class="form-control">
								@foreach ($tableSubcategories as $tableSubcategory)
									<option>{{ __($tableSubcategory->title) }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Threads') }}</p>
							<select multiple class="form-control">
								@foreach ($threads as $thread)
									<option>{{ $thread->title }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Posts') }}</p>
							<select multiple class="form-control">
								@foreach ($posts as $post)
									<option>{{ $post->id }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col superadmin-select">
						<div class="form-group">
							<p>{{ __('Users') }}</p>
							<select multiple class="form-control">
								@foreach ($users as $user)
									<option>{{ $user->username }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		@endsection
	@endcomponent
@endsection