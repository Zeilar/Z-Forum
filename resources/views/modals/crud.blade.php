<div id="crudModal" class="modal fade">
	<div class="modal-dialog modal-crud">
		<div class="modal-content">
			<form method="POST" action="{{route($route_name ?? '', $route_values ?? '')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="{{$method ?? 'post'}}">
				<div class="modal-header">				
					<h4 class="modal-title">{{ $title ?? __('Create new item') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="form-group">
						<label>{{ __('Title') }}</label>
						@error('title') <p class="color-red" id="error-create">{{ $message }}</p> @enderror
						<input type="text" id="create_title" name="title" autocomplete="off" value="{{old('title')}}"
							class="form-control @error('title') is-invalid @enderror" autofocus
						/>
					</div>
					<div class="form-group">
						<p>{{ __('Icon') }}</p>
						<label class="file-upload" for="create_icon">
							<i class="fas color-white fa-upload"></i>
							<span>{{ __('Choose a file') }}</span>
						</label>
						@error('icon') <p class="color-red" id="error-create">{{ $message }}</p> @enderror
						<input type="file" id="create_icon" name="icon" value="{{old('icon')}}"
							class="form-control @error('icon') is-invalid @enderror"
						/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn spin rounded btn-block btn-success-full" disabled>
						<span>{{ $submit ?? __('Create') }}</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>