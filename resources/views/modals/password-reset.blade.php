<div id="passwordresetModal" class="modal fade">
	<div class="modal-dialog modal-auth">
		<div class="modal-content">
			<form method="POST" action="{{route('password.email')}}">
				@csrf
				<div class="modal-header">				
					<h4 class="modal-title">{{ __('Reset password') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="form-group">
						<label>{{ __('Email') }}</label>
						@if (session('status')) <p class="success">{{ session('status') }}</p> @endif
						@error('email') <p class="color-red" id="error-email">{{ $message }}</p> @enderror
						<input type="email" id="register_email" name="email" 
							class="form-control @error('email') is-invalid @enderror" autofocus
							value="{{old('email')}}" placeholder="john.doe@gmail.com"
						/>
					</div>
				</div>
				<div class="modal-footer">		
					<button type="submit" class="btn spin rounded btn-block btn-success" disabled>
						<span>{{__('Reset')}}</span>
					</button>
					<p>
						{{ __('Already a member?') }}
						<a data-toggle="modal" data-dismiss="modal" href="#loginModal">{{ __('Sign in') }}</a>
					</p>
				</div>
			</form>
		</div>
	</div>
</div> 