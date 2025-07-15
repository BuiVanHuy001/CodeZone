<div class="accordion-body card-body">
    <h6>Company's employees</h6>
    <div class="rbt-dashboard-table table-responsive mobile-table-750">
        <table class="rbt-table table table-borderless">
            <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @forelse($employees->sortBy('created_at') as $employee)
                <tr>
                    <th>#{{ $loop->iteration}}</th>
                    <td class="d-flex align-items-center">
                        <div class="rbt-avatars size-sm">
                            <img src="{{ $employee->user->getAvatarPath() }}" alt="Author Images">
                        </div>
                        {{ $employee->user->name }}
                    </td>
                    <td><span class="rbt-badge-5 bg-color-success-opacity color-success">Active</span>
                    </td>
                    <td>
                        <div class="rbt-button-group justify-content-end">
                            @if(in_array($employee->user->id, $learners))
                                <a class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger" wire:click.prevent="removeEmployeeAssign({{ $employee->user->id }})" title="Delete"><i class="feather-user-minus pl--0"></i></a>
                            @else
                                <a class="rbt-btn btn-xs bg-primary-opacity radius-round color-primary" wire:click.prevent="addEmployeeAssign({{ $employee->user->id }})" title="Add"><i class="feather-user-plus pl--0"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No employees found</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>
