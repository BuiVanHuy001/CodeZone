@if ($paginator->hasPages() || $paginator->total() > 0)
    <nav class="d-flex justify-content-between align-items-center w-100 mt-3">

        <div class="d-flex align-items-center gap-2">
            @if(property_exists($this, 'perPage'))
                <select wire:model.live="perPage" class="form-select form-select-sm" style="width: 70px; cursor: pointer;">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            @endif

            <div class="text-muted small text-nowrap">
                Hiển thị <span class="fw-semibold">{{ $paginator->firstItem() ?? 0 }}</span>
                đến <span class="fw-semibold">{{ $paginator->lastItem() ?? 0 }}</span>
                trong tổng số <span class="fw-semibold">{{ $paginator->total() }}</span> kết quả
            </div>
        </div>

        @if ($paginator->hasPages())
            <div>
                <ul class="pagination pagination-sm mb-0">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button type="button"
                                    class="page-link"
                                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    rel="prev"
                                    aria-label="@lang('pagination.previous')">
                                &lsaquo;
                            </button>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item">
                                        <button type="button"
                                                class="page-link"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">
                                            {{ $page }}
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <button type="button"
                                    class="page-link"
                                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    rel="next"
                                    aria-label="@lang('pagination.next')">
                                &rsaquo;
                            </button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </nav>
@endif
