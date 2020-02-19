<div class="modal fade" id="errorModal">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 class="modal-title color-white" id="errorModalLabel">{{ __('Error') }}</h5>
		  		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
		  		</button>
			</div>
			<div class="modal-body">
				@if (session('error')) <p id="error-any">{{ session('error') }}</p> @endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
			</div>
		</div>
	</div>
</div>