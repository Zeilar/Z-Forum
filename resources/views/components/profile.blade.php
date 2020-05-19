<div class="user-profile">
	<div class="profile-upper">
		<div class="profile-avatar">
			<img class="img-fluid" src="{{$user->avatar}}" alt="{{ __('User profile avatar') }}">
		</div>

		<div class="profile-meta">
			<div class="profile-meta-block profile-name">
				<h3 class="profile-username">
					@isset($user->username)
						{{ $user->username }}
					@else
						<i>{{ __('Deleted') }}</i>
					@endisset
				</h3>
				<h3 class="profile-role {{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</h3>
				<h3 class="profile-rank">{{ ucwords($user->rank) }}</h3>
			</div>

			<div class="profile-meta-stats">
				<div class="profile-registered profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Joined ') }}</h4>
					<h4 class="profile-meta-lower">{{ pretty_date($user->created_at, ['format' => 'F NS Y']) }}</h3>
				</div>
				<div class="profile-likes profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Post likes') }}</h5>
					<h4 class="profile-meta-lower">{{ $posts_with_likes->count() }}</h4>
				</div>
				<div class="profile-posts profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Posts') }}</h4>
					<h4 class="profile-meta-lower">{{ $user->posts->count() }}</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="profile-middle">
		<div class="profile-signature">
			@isset($user->signature)
				<p class="signature">{{ $user->signature }}</p>
			@else
				<p class="no-signature">{{ __('User has no signature') }}</p>
			@endisset
		</div>
	</div>

	<div class="profile-nav">
		<a class="profile-nav-item @if($active === 'activity') active @endif" href="{{route('user_activity', [$user->id])}}">
			{{ __('Activity') }}
		</a>
		<a class="profile-nav-item @if($active === 'threads') active @endif" href="{{route('user_threads', [$user->id])}}">
			{{ __('Threads') }}
		</a>
		<a class="profile-nav-item @if($active === 'posts') active @endif" href="{{route('user_posts', [$user->id])}}">
			{{ __('Posts') }}
		</a>
		<a class="profile-nav-item @if($active === 'likes') active @endif" href="{{route('user_likes', [$user->id])}}">
			{{ __('Likes') }}
		</a>
        <a class="profile-nav-item @if($active === 'messages') active @endif" href="{{route('user_messages', [$user->id])}}">
			{{ __('Messages') }}
		</a>
	</div>
	
	@isset($activities)
		{{ $activities }}
	@endisset

	@isset($threads)
		{{ $threads }}
	@endisset

	@isset($posts)
		{{ $posts }}
	@endisset

	@isset($likes)
		{{ $likes }}
	@endisset

    @isset($messages)
		{{ $messages }}
	@endisset
		
	@isset($pagination)
		{{ $pagination }}
	@endisset
</div>

@can('suspend', $user)
    @section('toolbarItem')
        @component('components.toolbar-item', ['cookie' => 'user'])
            @slot('icon')
                <i class="fas fa-user"></i>
            @endslot

            @slot('categoryTitle')
                {{ $user->username }}
            @endslot

            @slot('toolbarSubitem')
                @component('components.toolbar-subitem')
                    @slot('subitemTitle')
                        {{ __('Edit user') }}
                    @endslot

                    @slot('formAction')
                        {{ route('user_update', [$user->id]) }}
                    @endslot

                    @slot('content')
                        <img class="file-upload-preview img-fluid" src="{{$user->avatar}}" alt="{{ __('Profile avatar') }}">
                        @error('avatar') <p style="color: red;">{{ $message }}</p> @enderror
                        <label class="file-upload" for="avatar-upload">
                            <i class="fas color-white fa-upload"></i>
                            <span>{{ __('Upload file') }}</span>
                        </label>
                        <input type="file" id="avatar-upload" name="avatar" />

                        <label>{{ __('Username') }}</label>
                        @error('username') <p style="color: red;">{{ $message }}</p> @enderror
                        <input type="text" name="username" placeholder="{{$user->username}}" autocomplete="off" />

                        <label>{{ __('Email') }}</label>
                        @error('email') <p style="color: red;">{{ $message }}</p> @enderror
                        <input type="email" name="email" placeholder="{{$user->email}}" autocomplete="off" />

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
                        <select name="role" id="user-role">
                            @foreach ($enums as $enum)
                                <option @if($enum === $user->role) selected @endif value="{{$enum}}">{{ ucfirst($enum) }}</option>
                            @endforeach
                        </select>

                        <label>{{ __('Signature') }}</label>
                        @error('signature') <p style="color: red;">{{ $message }}</p> @enderror
                        <textarea name="signature" id="user-signature" rows="3"><?= $user->signature ?></textarea>

                        <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    @endslot
                @endcomponent

                @component('components.toolbar-subitem')
                    @slot('subitemTitle')
                        {{ __('Suspension') }}
                    @endslot

                    @slot('formAction')
                        @if ($user->is_suspended())
                            {{ route('user_pardon', [$user->id]) }}
                        @else
                            {{ route('user_suspend', [$user->id]) }}
                        @endif
                    @endslot

                    @slot('content')
                        @if ($user->is_suspended())
                            <p class="suspended">{{ pretty_date($user->suspended) }}</p>
                            @isset($user->suspended_reason)
                                <p class="suspended-reason">{{ $user->suspended_reason }}</p>
                            @endisset
                            <button class="btn btn-success user-pardon" type="submit">{{ __('Pardon') }}</button>
                        @else
                            <label>{{ __('Day') }}</label>
                            @error('day') <p style="color: red;">{{ $message }}</p> @enderror
                            <select name="day" id="suspend-day">
                                <option></option>
                                @for ($i = 1; $i < 32; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>

                            <label>{{ __('Month') }}</label>
                            @error('month') <p style="color: red;">{{ $message }}</p> @enderror
                            <select name="month" id="suspend-month">
                                <option></option>
                                <option value="1">{{ __('January') }}</option>
                                <option value="2">{{ __('February') }}</option>
                                <option value="3">{{ __('March') }}</option>
                                <option value="4">{{ __('April') }}</option>
                                <option value="5">{{ __('May') }}</option>
                                <option value="6">{{ __('June') }}</option>
                                <option value="7">{{ __('July') }}</option>
                                <option value="8">{{ __('August') }}</option>
                                <option value="9">{{ __('September') }}</option>
                                <option value="10">{{ __('October') }}</option>
                                <option value="11">{{ __('November') }}</option>
                                <option value="12">{{ __('December') }}</option>
                            </select>

                            <label>{{ __('Year') }}</label>
                            @error('year') <p style="color: red;">{{ $message }}</p> @enderror
                            <select name="year" id="suspend-year">
                                <option></option>
                                @php $year = (int)date('Y') @endphp
                                @for ($i = $year; $i < $year + 11; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>                                
                                @endfor
                            </select>

                            <label>{{ __('Reason') }}</label>
                            <input type="text" name="reason" autocomplete="off">

                            <button class="btn btn-hazard user-suspend" type="submit">{{ __('Suspend') }}</button>
                        @endif
                    @endslot
                @endcomponent
            @endslot
        @endcomponent
    @endsection
@endcan