@if ($paginator->hasPages())
    <div class="pagination menu" role="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage() && $paginator->hasMorePages()))
            <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev"> 
				<i class="fas fa-chevron-left"></i>
				{{ __('Prev') }}
			</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="item dots" href="#">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="item active" href="{{ $url }}" aria-current="page">{{ $page }}</a>
                    @else
                        <a class="item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="icon item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
				{{ __('Next') }}
				<i class="fas fa-chevron-right"></i>
			</a>
        @endif
    </div>
@endif
