@extends('head')

@section('pageTitle')
	{{ __('User | ') . ($user->username ?? __('Deleted')) }}
@endsection

@section('content')
	@include('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => ''])
@endsection

@can('suspend', $user)
    @section('toolbarItem')
        @component('components.toolbar-item', ['cookie' => 'user'])
            @slot('categoryTitle')
                {{ $user->username }}
            @endslot

            @slot('toolbarSubitem')
                @component('components.toolbar-subitem')
                    @slot('subitemTitle')
                        {{ __('Suspend user') }}
                    @endslot

                    @slot('formAction')
                        {{ route('user_suspend', [$user->id]) }}
                    @endslot

                    @slot('content')
                        @if ($user->is_suspended())
                            <p class="suspended">{{ pretty_date($user->suspended) }}</p>
                        @endif

                        @error('day') <p style="color: red;">{{ $message }}</p> @enderror
                        <select name="day" id="suspend-day">
                            <option></option>
                            @for ($i = 1; $i < 32; $i++)
                                <option value="{{ $i }}">
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>

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

                        @error('year') <p style="color: red;">{{ $message }}</p> @enderror
                        <select name="year" id="suspend-day">
                            <option></option>
                            @php $year = (int)date('Y') @endphp
                            @for ($i = $year; $i < $year + 11; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>                                
                            @endfor
                        </select>
                        <button class="btn btn-hazard user-suspend">{{ __('Suspend') }}</button>
                    @endslot
                @endcomponent
            @endslot
        @endcomponent
    @endsection
@endcan