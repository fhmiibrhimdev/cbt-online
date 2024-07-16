<div>
    @if ($paginator->hasPages())
        <nav class="tw-block tw-text-center lg:tw-flex">
            <div class="tw-mt-3 tw-mb-5 lg:tw-mb-0">
                Showing {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }}
                to {{ ($paginator->currentPage() - 1) * $paginator->perPage() + count($paginator->items()) }}
                of {{ $paginator->total() }} entries
            </div>
            <ul class="pagination tw-justify-center lg:tw-ml-auto">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                            class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @php
                            $pageNumber = ($paginator->currentPage() - 1) * $paginator->perPage();
                        @endphp
                        @foreach ($element as $page => $url)
                            @if ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}"
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                                    <button type="button" class="page-link"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                            class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</button>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
