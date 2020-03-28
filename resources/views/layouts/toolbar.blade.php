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
				{{-- TODO: JS cookie toolbar --}}
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
			$(document).ready(() => {
				collapse();
			});

			$('.toolbar-collapse').click(function() {
				// Create date string for expiration date, which is 24 hours from now
				let date = new Date();
				date.setTime(date.getTime() + (60 * 60 * 24));
				let expires = `${date.toUTCString()}`;

				// Add cookie to keep the collapse open
				document.cookie = `collapseIndex=${$(this).parent().index()}; expires=${expires}; path=/`;

				// Reset all collapsibles when any is opened
				$('.toolbar-accordion').close().removeAttr('style');
				$('.fa-caret-left').css('transform', 'rotate(0)');

				let accordion = $(this).siblings('.toolbar-accordion');
				if (accordion.height()) {
					accordion.close();
					$(this).find('.fa-caret-left').css('transform', 'rotate(0)');
				} else {
					accordion.collapse();
					$(this).find('.fa-caret-left').css('transform', 'rotate(-90deg)');
				}
			});

			function collapse() {
				// Separate the cookies
				let cookies = document.cookie;
				cookies = cookies.split(';');

				let collapseIndex = '';
				for (let i = 0; i < cookies.length; i++) {
					if (cookies[i].search('collapseIndex') !== -1) {
						collapseIndex = cookies[i];
						break;
					}
				}

				if (collapseIndex !== '') {
					// Get the int value of the cookie
					collapseIndex = Number(collapseIndex.split('=')[1]);

					// Since nth-child indexes aren't like arrays, it starts at 1
					collapseIndex += 1;

					$(`.toolbar-row:nth-child(${collapseIndex})`).find('.toolbar-accordion').css('transition', 'none').collapse();
				}
			}
		</script>
	@endcan
@endauth