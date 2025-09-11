<div class="accordion-body card-body">
    <h6>Member List</h6>
    <div class="rbt-dashboard-table table-responsive mobile-table-750">
        <div class="search-group mb-3">
            <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                </g>
            </svg>
            <input placeholder="Search" wire:model.blur="search" type="search" class="input">
        </div>
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
            @forelse($members as $member)
                <tr>
                    <th>#{{ $loop->iteration}}</th>
                    <td class="d-flex align-items-center">
                        <div class="rbt-avatars size-sm">
                            <img src="{{ $member->user->getAvatarPath() }}" loading="lazy" alt="Author Images">
                        </div>
                        {{ $member->user->name }}
                    </td>
                    <td><span class="rbt-badge-5 bg-color-success-opacity color-success">Active</span>
                    </td>
                    <td>
                        <div class="rbt-button-group justify-content-end">
                            @if(in_array($member->user->id, $learners))
                                <a class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger" wire:click.prevent="removeMemberAssign({{ $member->user->id }})" title="Delete"><i class="feather-user-minus pl--0"></i></a>
                            @else
                                <a class="rbt-btn btn-xs bg-primary-opacity radius-round color-primary" wire:click.prevent="addMemberAssign({{ $member->user->id }})" title="Add"><i class="feather-user-plus pl--0"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No members found</td>
                </tr>
            @endforelse
        </table>
        {{ $members->links('livewire::bootstrap') }}
    </div>
</div>
