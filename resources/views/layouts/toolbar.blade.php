@auth
	@can('delete', App\User::find(1))
		<div id="toolbar">
			<ul class="toolbar-items">
				<div class="toolbar-row">
					<div class="toolbar-icon">
						<i class="fas fa-users"></i>
					</div>
					<ul class="toolbar-item">
						<li class="toolbar-subitem spoof-login">
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
						<div class="toolbar-icon">
							<i class="fas fa-tools"></i>
						</div>
						<ul class="toolbar-item">
							<li class="toolbar-sub item maintenance-mode">
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
			$(document).ready(() => {
				collapse();
			});

			$('.toolbar-collapse').click(function() {
				// Add collapsible index to local storage to keep it open through all pages
				localStorage.setItem('toolbarCollapseIndex', $(this).parent().index())

				// Reset all collapsibles and minuses when any is opened
				$('.toolbar-collapse .plus').removeAttr('style').css('opacity', '1');
				$('.toolbar-accordion').close().removeAttr('style');

				let accordion = $(this).siblings('.toolbar-accordion');
				if (accordion.height()) {
					// Reset localStorage if there was any so that it stays closed
					localStorage.removeItem('toolbarCollapseIndex');

					$(this).find('.plus').css('opacity', '1');
					accordion.close();
				} else {
					$(this).find('.plus').css('opacity', '0');
					accordion.collapse();
				}
			});

			function collapse() {
				if (localStorage.getItem('toolbarCollapseIndex') != null) {
					// Convert to number so we can add 1 onto it easier
					// We add 1 because nth:child() starts at 1 rather than 0
					let collapseIndex = Number(localStorage.getItem('toolbarCollapseIndex')) + 1;

					// Collapse the last opened collapsible and their plus and remove the animation to make it look more seamless
					let collapsible = $(`.toolbar-row:nth-child(${collapseIndex})`);
					collapsible.find('.toolbar-accordion').css('transition', 'none').collapse();
					collapsible.find('.plus').css({
						'transition': 'none',
						'opacity': '0',
					});
				}
			}
		</script>
	@endcan
@endauth