@isset($post)
    @php $user = $post->user @endphp
    
    @if (auth()->check() && $user->id === auth()->user()->id)
        @php $attribute = 'is_author' @endphp
    @elseif ($user->id === $post->thread->user->id)
        @php $attribute = 'is_op' @endphp
    @else
        @php $attribute = '' @endphp
    @endif
        
    <article class="post" id="{{$post->id}}">
        @empty($disablePostBanner)
            @if ($user->is_suspended())
                <div class="post-banner suspended">
                    <span class="post-banner-role">{{ __('Suspended') }}</span>
                </div>
            @endif
            @if ($user->is_role('moderator', 'superadmin'))
                <div class="post-banner {{role_coloring($user->role)}}">
                    <span class="post-banner-role">{{ $user->role }}</span>
                </div>
            @endif
        @endempty

        <div class="post-header">
            <div class="post-meta {{$attribute}}">
                <a class="post-avatar-link" href="{{route('user_show', [$user->id])}}">
                    <div class="post-avatar @if($user->is_online() && !$user->is_suspended()) is_online @endif">
                        <img class="img-fluid" src="{{$user->avatar}}" alt="{{ __('Post user avatar') }}" />

                        <div class="avatar-meta">
                            @if ($user->is_suspended())
                                <p class="suspended">{{ __('Suspended') }}</p>
                            @else
                                @if ($user->is_online()) 
                                    <p class="status">{{ __('Online') }}</p> 
                                @else
                                    <p class="status">{{ __('Offline') }}</p>
                                @endif
                                @isset($user->last_seen)
                                    @php $date = new \Carbon\Carbon($user->last_seen) @endphp
                                    <p>{{ $date->diffForHumans() }}</p>
                                @endisset
                            @endif
                        </div>
                    </div>
                </a>
                    
                <div class="post-meta-text">
                    <div class="post-meta-left">
                        <p class="post-author">
                            <a href="{{route('user_show', [$user->id])}}">
                                @isset($user->username)
                                    {{ $user->username }}
                                @else
                                    <i>{{ __('Deleted') }}</i>
                                @endisset
                            </a>
                        </p>
                        <p class="post-author-rank">
                            {{ __(ucfirst($user->rank)) }}
                        </p>
                    </div>
                    
                    <div class="post-meta-right">
                        @isset($i)
                            <span class="post-i">#{{ $i }}</span>
                        @endisset

                        <div class="post-link">
                            @isset($banner_link)
                                {{ $banner_link }}
                            @else
                                <a class="permalink" href="{{route('post_permalink', [$post->id])}}" title="{{ __('Copy') }}">
                                    {{ pretty_date($post->created_at) }}
                                    <i class="fas fa-copy"></i>
                                </a>
                                
                                <a class="ml-2" href="{{route('post_permalink', [$post->id])}}" target="_blank" title="{{ __('Open in new window') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endisset
                        </div>
                    </div> {{-- .post-meta-text --}}
                </div>
            </div>
        </div> {{-- .post-header --}}

        <div class="post-body">
            {!! $post->content !!}
        </div>
        
        @empty($disablePostSignature)
            @isset($user->signature)
                <div class="post-signature">
                    {{ $user->signature }}
                </div>
            @endisset
        @endempty

        @isset($post->edited_by)
            <div class="post-edited-by">
                @php $user = App\User::find($post->edited_by) @endphp
                <p class="edited-by">
                    {{ __('Edited by ') }}
                    <a class="{{role_coloring($user->role)}}" href="{{route('user_show', [$user->id])}}">
                        {{ $user->username }}
                    </a>
                    {{ __(' at ') . $post->updated_at }}
                </p>
                @isset($post->edited_by_message)
                    <p class="edited-message">"{{ $post->edited_by_message }}"</p>
                @endisset
            </div>
        @endisset

        @auth
            @empty($disablePostToolbar)
                @can('create', [App\Post::class, $post->thread])
                    <div class="post-toolbar">
                        @can('update', $post)
                            <button class="btn btn-default post-edit">
                                <span>{{ __('Edit') }}</span>
                            </button>
                        @endcan

                        @empty($disableQuoteButton)
                            <button class="btn btn-default post-quote">
                                <span>{{ __('Quote') }}</span>
                            </button>
                        @endempty
                        
                        @if (auth()->user()->likes->contains('post_id', $post->id))
                            @php $isLiked = 'success' @endphp
                        @else
                            @php $isLiked = 'default' @endphp
                        @endif
                        <button class="btn btn-{{$isLiked}} post-like">
                            <i class="far fa-thumbs-up"></i>
                            <span class="like-amount">
                                (<span class="like-amount-number">{{ count($post->likes) }}</span>)
                            </span>
                            @if ($isLiked === 'success')	
                                <span class="like-indicator">+1</span>
                            @endif
                        </button>

                        @can('delete', $post)
                            <button class="btn btn-hazard spin post-delete">
                                {{ __('Delete') }}
                            </button>
                        @endcan
                    </div>
                @endcan
            @endempty
        @endauth
    </article>
@endisset