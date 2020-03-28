@auth
	@can('delete', App\User::find(1))
		<div id="toolbar">
			<ul class="toolbar-items">
				<div class="toolbar-row">
					<div class="toolbar-collapse">
						<i class="fas fa-users"></i>
						<span>{{ __('Users') }}</span>
						<i class="fas fa-caret-left"></i>
					</div>
					<ul class="toolbar-accordion">
						<li class="toolbar-item spoof-login">
							<p class="title">{{ __('Spoof login') }}</p>
							<form action="{{route('spoof_login')}}" method="post">
								@csrf
								<fieldset>
									<legend>{{ __('Spoof login') }}</legend>
									<input type="text" name="user" placeholder="{{ __('Username or ID') }}" autocomplete="off">
								</fieldset>
							</form>
						</li>
					</ul>
				</div>

				@can('update', App\MaintenanceMode::find(1))
					<div class="toolbar-row">
						<div class="toolbar-collapse">
							<i class="fas fa-tools"></i>
							<span>{{ __('System') }}</span>
							<i class="fas fa-caret-left"></i>
						</div>
						<ul class="toolbar-accordion">
							<li class="toolbar-item maintenance-mode">
								<p class="title">{{ __('Maintenance mode') }}</p>
								<form action="{{route('toggle_maintenance_mode')}}" method="post">
									@csrf
									<button class="btn btn-hazard" type="submit">
										<i class="fas fa-exclamation-triangle"></i>
										@if (App\MaintenanceMode::find(1)->enabled)
											{{ __('Turn OFF') }}
										@else
											{{ __('Turn ON') }}
										@endif
									</button>
								</form>
							</li>
						</ul>
					</div>					
				@endcan

				@isset($toolbarItems)
					@foreach ($toolbarItems as $item)
						{{ $item }}
					@endforeach
				@endisset
			</ul>
		</div>

		<script>
			$('.toolbar-collapse').click(function() {
				// Reset all collapsibles when any is opened
				$('.toolbar-accordion').close().removeAttr('style');
				$('.fa-caret-left').css('transform', 'rotate(0)');

				let accordion = $(this).siblings('.toolbar-accordion');
				if (accordion.height()) {
					accordion.close().css('margin-bottom', '0');
					$(this).find('.fa-caret-left').css('transform', 'rotate(0)');
				} else {
					accordion.collapse();

					// Only add margin bottom if child is not last
					if (accordion.index() !== $('.toolbar-accordion').length - 1) {
						accordion.css('margin-bottom', '1rem');
					}

					$(this).find('.fa-caret-left').css('transform', 'rotate(-90deg)');
				}
			});
		</script>
	@endcan
@endauth