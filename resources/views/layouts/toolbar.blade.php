@auth
	@if (auth()->user()->is_role('moderator', 'superadmin'))
		<div id="toolbar">
            <button class="toolbar-toggle" type="button">
                <i class="fas fa-exchange-alt @empty($_COOKIE['toolbarOpen']) color-white @endempty"></i>
            </button>

			<ul class="toolbar-items @empty($_COOKIE['toolbarOpen']) hidden @endempty">
                @if (auth()->user()->is_role('superadmin'))
                    @component('components.toolbar-item', ['cookie' => 'users'])
                        @slot('icon')
                            <i class="fas fa-users"></i>
                        @endslot

                        @slot('categoryTitle')
                            {{ __('Users') }}
                        @endslot

                        @slot('toolbarSubitem')
                            @component('components.toolbar-subitem')
                                @slot('subitemTitle')
                                    {{ __('Spoof login') }}
                                @endslot

                                @slot('formAction')
                                    {{ route('spoof_login') }}
                                @endslot

                                @slot('content')
                                    <input type="text" name="user" placeholder="{{ __('Username or ID') }}" autocomplete="off">
                                @endslot
                            @endcomponent
                        @endslot
                    @endcomponent
                @endif

				@can('update', App\MaintenanceMode::find(1))
                    @component('components.toolbar-item', ['cookie' => 'configuration'])
                        @slot('icon')
                            <i class="fas fa-tools"></i>
                        @endslot

                        @slot('categoryTitle')
                            {{ __('Configuration') }}
                        @endslot

                        @slot('toolbarSubitem')
                            @component('components.toolbar-subitem')
                                @slot('subitemTitle')
                                    {{ __('Maintenance mode') }}
                                @endslot

                                @slot('formAction')
                                    {{ route('toggle_maintenance_mode') }}
                                @endslot

                                @slot('content')
                                    <button class="btn btn-hazard" type="submit">
										<i class="fas mr-2 fa-exclamation-triangle"></i>
										@if (App\MaintenanceMode::find(1)->enabled)
											{{ __('Turn OFF') }}
										@else
											{{ __('Turn ON') }}
										@endif
									</button>
                                @endslot
                            @endcomponent
                        @endslot
                    @endcomponent				
				@endcan

				@yield('toolbarItem')
			</ul>
		</div>
	@endcan
@endauth