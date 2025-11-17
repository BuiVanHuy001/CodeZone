<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $tableTitle }}</h5>
        </div>
        <div class="card-body">
            <table id="{{ $tableId }}" class="table nowrap align-middle" style="width:100%">
                <thead>
                <tr>
                    {{ $tableHeader }}
                </tr>
                </thead>

                <tbody>{{ $tableBody }}</tbody>
            </table>
        </div>
    </div>
</div>
