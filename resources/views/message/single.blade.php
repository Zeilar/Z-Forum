@extends('head')

@section('pageTitle')
	{{ $message->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('message', $message) }}
@endsection

@section('content')
	@include('components.message', ['message' => $message, 'replyButton' => true])
@endsection

@can('delete', $message)
    @section('toolbarItem')
        @component('components.toolbar-item', ['cookie' => 'message'])
            @slot('icon')
                <i class="fas fa-envelope"></i>
            @endslot

            @slot('categoryTitle')
                {{ __('Message') }}
            @endslot

            @slot('toolbarSubitem')
                @can('update', $message)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Edit message') }}
                        @endslot

                        @slot('content')
                            @error('content') <p style="color: red;">{{ $message }}</p> @enderror
                            <textarea name="content" id="message-edit" rows="5"><?= old('content') ?? $message->content ?></textarea>
                        @endslot
                    @endcomponent
                @endcan

                @can('delete', $message)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Delete message') }}
                        @endslot

                        @slot('formAction')
                            {{ route('message_delete', [$message->id]) }}
                        @endslot

                        @slot('content')
                            <button class="btn btn-hazard" type="submit">
                                <i class="fas mr-2 fa-exclamation-triangle"></i>
                                <span>{{ __('Delete') }}</span>
                            </button>
                        @endslot
                    @endcomponent
                @endcan
            @endslot
        @endcomponent
    @endsection
@endcan