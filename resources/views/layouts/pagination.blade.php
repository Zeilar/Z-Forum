@if ($paginator->hasPages())
    <div class="pagination" role="navigation" data-current-page="{{$paginator->currentPage()}}">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
			<div class="item-wrapper">
				<a class="item first" href="{{url()->current()}}" rel="prev">
					<i class="fas fa-chevron-left"></i>
					<i class="fas fa-chevron-left"></i>
				</a>
			</div>

			<div class="item-wrapper">
				<a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev"> 
					{{ __('Prev') }}
				</a>
			</div>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
				<div class="item-wrapper">
                	<p class="item dots" href="#" id="pagination-dots">{{ $element }}</p>
				</div>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
						<div class="item-wrapper">
                        	<a class="item active" href="{{ $url }}" aria-current="page">
								<span>{{ $page }}</span>
							</a>
						</div>
                    @else
						<div class="item-wrapper">
							<a class="item" href="{{ $url }}">
								<span>{{ $page }}</span>
							</a>
						</div>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
			<div class="item-wrapper">
				<a class="icon item" href="{{ $paginator->nextPageUrl() }}" rel="next">
					{{ __('Next') }}
				</a>
			</div>
        @endif

		@if ($paginator->currentPage() !== $paginator->lastPage())
			<div class="item-wrapper">
				<a class="item last" href="{{$paginator->lastPage()}}" rel="prev">
					<i class="fas fa-chevron-right"></i>
					<i class="fas fa-chevron-right"></i>
				</a>
			</div>
		@endif
    </div>
@endif