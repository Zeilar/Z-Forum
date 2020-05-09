@auth
	@if (auth()->user()->is_role('moderator', 'superadmin'))
		<div id="toolbar">
			<ul class="toolbar-items">
                @if (auth()->user()->is_role('superadmin'))
                    @component('components.toolbar-item')
                        @slot('cookie')
                            users
                        @endslot

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
                    @component('components.toolbar-item')
                        @slot('cookie')
                            configuration
                        @endslot

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