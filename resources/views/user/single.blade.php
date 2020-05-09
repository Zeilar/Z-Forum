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
            @slot('icon')
                <i class="fas fa-user"></i>
            @endslot

            @slot('categoryTitle')
                {{ $user->username }}
            @endslot

            @slot('toolbarSubitem')
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
                            <button class="btn btn-success user-pardon" type="submit">{{ __('Pardon') }}</button>
                        @else
                            <p class="select-header">{{ __('Day') }}</p>
                            @error('day') <p style="color: red;">{{ $message }}</p> @enderror
                            <select name="day" id="suspend-day">
                                <option></option>
                                @for ($i = 1; $i < 32; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>

                            <p class="select-header">{{ __('Month') }}</p>
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

                            <p class="select-header">{{ __('Year') }}</p>
                            @error('year') <p style="color: red;">{{ $message }}</p> @enderror
                            <select name="year" id="suspend-year">
                                <option></option>
                                @php $year = (int)date('Y') @endphp
                                @for ($i = $year; $i < $year + 11; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>                                
                                @endfor
                            </select>

                            <button class="btn btn-hazard user-suspend" type="submit">{{ __('Suspend') }}</button>
                        @endif
                    @endslot
                @endcomponent
            @endslot
        @endcomponent
    @endsection
@endcan