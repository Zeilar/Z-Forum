<div id="crudModal" class="modal fade">
	<div class="modal-dialog modal-crud">
		<div class="modal-content">
			<form method="POST" action="{{route($route_name ?? '', $route_values ?? '')}}">
				@csrf
				@isset($method)
					<input type="hidden" name="_method" value="{{$method}}">
				@endisset
				<div class="modal-header">				
					<h4 class="modal-title">{{ $title ?? '' }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="form-group">
						<label>{{ __('Title') }}</label>
						@error('title') <p class="color-red" id="error-create">{{ $message }}</p> @enderror
						<input type="text" id="create_title" name="title" autocomplete="off"
							class="form-control @error('title') is-invalid @enderror" autofocus
						/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn spin rounded btn-block btn-success" disabled>
						<span>{{ $submit ?? '' }}</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>