@auth
	@if (auth()->user()->is_role('moderator', 'superadmin') && !auth()->user()->is_suspended())
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
                                    @error('user') <p style="color: red;">{{ $message }}</p> @enderror
                                    <input type="text" name="user" placeholder="{{ __('Username or ID') }}" autocomplete="off">
                                @endslot
                            @endcomponent

                            @component('components.toolbar-subitem')
                                @slot('subitemTitle')
                                    {{ __('Create user') }}
                                @endslot

                                @slot('formAction')
                                    {{ route('user_store') }}
                                @endslot

                                @slot('content')
                                    <label>{{ __('Avatar') }}</label>
                                    @error('avatar') <p style="color: red;">{{ $message }}</p> @enderror
                                    <label class="file-upload" for="avatar-upload">
                                        <i class="fas color-white fa-upload"></i>
                                        <span>{{ __('Upload file') }}</span>
                                    </label>
                                    <input type="file" id="avatar-upload" name="avatar" />

                                    <label>{{ __('Username') }}</label>
                                    @error('username') <p style="color: red;">{{ $message }}</p> @enderror
                                    <input type="text" name="username" autocomplete="off" />

                                    <label>{{ __('Email') }}</label>
                                    @error('email') <p style="color: red;">{{ $message }}</p> @enderror
                                    <input type="email" name="email" autocomplete="off" />

                                    <label>{{ __('Role') }}</label>
                                    @error('role') <p style="color: red;">{{ $message }}</p> @enderror
                                    @php
                                        $type = DB::select(DB::raw("SHOW COLUMNS FROM users WHERE Field = 'role'"))[0]->Type;
                                        preg_match('/^enum\((.*)\)$/', $type, $matches);
                                        $enums = [];
                                        foreach (explode(',', $matches[1]) as $value) {
                                            $v = trim($value, "'");
                                            $enums = array_add($enums, $v, $v);
                                        }
                                    @endphp
                                    <select name="role">
                                        @foreach ($enums as $enum)
                                            <option value="{{$enum}}">{{ ucfirst($enum) }}</option>
                                        @endforeach
                                    </select>

                                    <label>{{ __('Signature') }}</label>
                                    @error('signature') <p style="color: red;">{{ $message }}</p> @enderror
                                    <textarea name="signature" rows="3"></textarea>

                                    <label>{{ __('Password') }}</label>
                                    @error('password') <p style="color: red;">{{ $message }}</p> @enderror
                                    <input type="password" name="password" />

                                    <button class="btn btn-success" type="submit">
                                        <i class="fas mr-2 fa-user-plus"></i>
                                        <span>{{ __('Create') }}</span>
                                    </button>
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