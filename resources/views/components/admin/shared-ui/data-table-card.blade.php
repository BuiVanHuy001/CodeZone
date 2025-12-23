<div class="{{ $noCard ? '' : 'card' }} h-100">
    @if(!$noCard)
        <div class="card-header d-flex align-items-center justify-content-between border-bottom-dashed">
            <h5 class="card-title mb-0">{{ $tableTitle }}</h5>
            <div>{{ $utilsButton ?? '' }}</div>
        </div>
    @endif

    <div class="{{ $noCard ? '' : 'card-body' }}">
        <table id="{{ $tableId }}" class="table table-hover table-nowrap align-middle mb-0 w-100">
            <thead class="table-light text-muted">
            <tr>
                {{ $tableHeader }}
            </tr>
            </thead>
            <tbody>
            {{ $tableBody }}
            </tbody>
        </table>
    </div>
</div>
