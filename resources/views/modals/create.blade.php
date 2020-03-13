<div id="createModal" class="modal fade">
	<div class="modal-dialog modal-create">
		<div class="modal-content">
			<form method="POST" action="{{route($route_name, $route_values)}}">
				@csrf
				<div class="modal-header">				
					<h4 class="modal-title">{{ $title ?? __('Create new item') }}</h4>
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
						{{__('Create')}}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>