<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="advance-tab-button mb--30">
        <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
            <li role="presentation">
                <a href="#" wire:click.prevent="setTab('list')" @class(['tab-button', 'active' => $activeTab === 'list']) id="list-tab-4" data-bs-toggle="tab"
                   data-bs-target="#list-4" role="tab" aria-controls="list-4" aria-selected="true">
                    <span class="title">Employees List</span>
                </a>
            </li>
            <li role="presentation">
                <a href="#" wire:click.prevent="setTab('add')" @class(['tab-button', 'active' => $activeTab === 'add']) class="" id="add-tab-4" data-bs-toggle="tab"
                   data-bs-target="#add-4" role="tab" aria-controls="add-4" aria-selected="false">
                    <span class="title">Add Employee</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div @class(['tab-pane fade', 'active show' => $activeTab === 'list']) id="list-4" role="tabpanel" aria-labelledby="list-tab-4">
            <div class="row g-5">
                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                    <table class="rbt-table table table-borderless">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Enrolled amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($employees->sortBy('created_at') as $employee)
                            <tr>
                                <td class="d-flex align-items-center gap-2">
                                    <div class="rbt-avatars size-sm">
                                        <img src="{{ $employee->user->getAvatarPath() }}" alt="Author Images">
                                    </div>
                                    <p>{{ $employee->user->name }}</p>
                                </td>
                                <td>
                                    <span class="rbt-badge-5 {{$employee->user->getStatusClassAttribute() }}">{{ $employee->user->getStatusLabelAttribute() }}</span>
                                </td>
                                <td>12</td>
                                <td>
                                    <div class="rbt-button-group justify-content-end">
                                        <a class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger" href="#" wire:click.prevent="deleteEmployee({{ $employee->user->id }})" title="Delete"><i class="feather-trash-2 pl--0"></i></a>
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
        </div>

        <div @class(['tab-pane fade', 'active show' => $activeTab === 'add']) id="add-4" role="tabpanel" aria-labelledby="add-tab-4">
            <div class="row g-5">
                <div class="col-lg-6">
                    <form wire:submit.prevent="searchUser" class="rbt-search-style-1">
                        <input @class(['border-danger'=> $errors->has('search')]) wire:model.blur="search" type="text" placeholder="Search Users">
                        <button class="search-btn"><i class="feather-search"></i></button>
                    </form>
                    @error('search')
                    <small class="d-block mt-2 mb-3 text-danger">
                        <i class="feather-info"></i> {{ $message }}
                    </small>
                    @enderror
                </div>
                @if(!is_null($userResults))
                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                        <table class="rbt-table table table-borderless">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($userResults as $user)
                                <tr>
                                    <th>{{ $user->email }}</th>
                                    <td>{{ $user->name  }}</td>
                                    <td>
                                        @if($user->idEmployee(auth()->user()))
                                            <div class="rbt-button-group justify-content-end">
                                                <a class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger" href="#" wire:click.prevent="deleteEmployee({{$user->id}})" title="Delete"><i class="feather-delete pl--0"></i></a>
                                            </div>
                                        @else
                                            <div class="rbt-button-group justify-content-end">
                                                <a class="rbt-btn btn-xs bg-primary-opacity radius-round" href="#" wire:click.prevent="addEmployee({{$user->id}})" title="Edit">
                                                    <i class="feather-user-plus pl--0"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No users found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
