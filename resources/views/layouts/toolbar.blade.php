@auth
	@can('delete', App\User::find(1))
		<div id="toolbar">
			<ul class="toolbar-items">
				<div class="toolbar-row">
					<div class="toolbar-icon">
						<i class="fas fa-users"></i>
                        <h4 class="toolbar-category">{{ __('Users') }}</h4>
					</div>
					<ul class="toolbar-item">
						<li class="toolbar-subitem spoof-login">
							<form action="{{route('spoof_login')}}" method="post">
								@csrf
								<div>
									<h5 class="subitem-title">{{ __('Spoof login') }}</h5>
									<input type="text" name="user" placeholder="{{ __('Username or ID') }}" autocomplete="off">
								</div>
							</form>
						</li>
					</ul>
				</div>

				@can('update', App\MaintenanceMode::find(1))
					<div class="toolbar-row">
						<div class="toolbar-icon">
							<i class="fas fa-tools"></i>
                            <h4 class="toolbar-category">{{ __('Configuration') }}</h4>
						</div>
						<ul class="toolbar-item">
							<li class="toolbar-subitem maintenance-mode">
								<h5 class="subitem-title">{{ __('Maintenance mode') }}</h5>
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

				@isset($toolbarItem)
					{{ $toolbarItem }}
				@endisset
			</ul>
		</div>

        <script>
            $('.toolbar-icon').click(function() {
                let item = $(this).siblings('.toolbar-item');
                $('.toolbar-item').not(item).removeClass('show');
                item.toggleClass('show');

                let icon = $(this);
                $('.toolbar-icon').not(icon).removeClass('active');
                icon.toggleClass('active');
            });
        </script>
	@endcan
@endauth