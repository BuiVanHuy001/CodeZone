<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="advance-tab-button mb--30">
        <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
            <li role="presentation">
                <a href="#" wire:click.prevent="setTab('list')" @class(['tab-button', 'active' => $activeTab === 'list']) id="list-tab-4" data-bs-toggle="tab"
                   data-bs-target="#list-4" role="tab" aria-controls="list-4" aria-selected="true">
                    <span class="title">Member List</span>
                </a>
            </li>
            <li role="presentation">
                <a href="#" wire:click.prevent="setTab('add')" @class(['tab-button', 'active' => $activeTab === 'add']) class="" id="add-tab-4" data-bs-toggle="tab"
                   data-bs-target="#add-4" role="tab" aria-controls="add-4" aria-selected="false">
                    <span class="title">Add Member</span>
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
                            <th>Order</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($members->sortBy('created_at') as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <div class="rbt-avatars size-sm">
                                        <img src="{{ $member->user->getAvatarPath() }}" alt="Author Images" loading="lazy">
                                    </div>
                                    <p>{{ $member->user->name }}</p>
                                </td>
                                <td>
                                    <span class="rbt-badge-5 {{$member->user->getStatusClassAttribute() }}">{{ $member->user->getStatusLabelAttribute() }}</span>
                                </td>
                                <td>
                                    <div class="rbt-button-group justify-content-end">
                                        <button
                                            class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger"
                                            wire:click.prevent="deleteMember({{ $member->user->id }})">
                                            <i class="feather-trash-2 pl--0"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No members found</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <div @class(['tab-pane fade', 'active show' => $activeTab === 'add']) id="add-4" role="tabpanel" aria-labelledby="add-tab-4">
            <div class="row g-5">
                <div class="col-lg-6 mb-2">
                    <form wire:submit.prevent="searchUser" class="rbt-search-style-1">
                        <input @class(['border-danger'=> $errors->has('search')])
                               wire:model.blur="search"
                               type="text" placeholder="Search Users"
                        >
                        <button class="search-btn"><i class="feather-search"></i></button>
                    </form>
                    @error('search')
                    <small class="d-block mt-2 mb-3 text-danger">
                        <i class="feather-info"></i> {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="col-lg-6 mb-2">
                    <button class="rbt-btn btn-border icon-hover btn-sm mb-3"
                            data-bs-toggle="modal"
                            data-bs-target="#importUser">
                        <span class="btn-text">Import from file</span>
                        <span class="btn-icon"><i class="feather-download-cloud"></i></span>
                    </button>
                </div>
                @if($hasImported)
                    <div class="rbt-dashboard-table table-responsive mobile-table-750 mt-3">
                        <table class="rbt-table table table-borderless">
                            <thead>
                            <tr>
                                <th>Order</th>
                                @foreach(array_keys($this->importedMembers[0]) as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($importedMembers as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @foreach($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                    <td>
                                        <button
                                            class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger"
                                            wire:click.prevent="deleteImportedMember({{ $loop->index }})">
                                            <i class="feather-delete pl--0"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-items-end gap-2">
                        <button wire:loading.attr="disabled"
                                class="rbt-btn btn-border icon-hover btn-sm mb-3"
                                wire:click.prevent="cancelImportMembers">
                            <span class="btn-text">Cancel</span>
                            <span class="btn-icon"><i class="feather-x-circle"></i></span>
                        </button>

                        <button wire:loading.attr="disabled"
                                class="rbt-btn icon-hover btn-sm mb-3"
                                wire:click.prevent="importMembers">
                            <span class="btn-text">Import</span>
                            <span class="btn-icon"><i class="feather-download-cloud"></i></span>
                        </button>
                        <div wire:loading wire:target="importMembers, cancelImportMembers"
                             class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center m-0 d-none"
                             style="background-color: rgba(0,0,0,0.5); z-index: 2000"
                             wire:loading.class.remove="d-none">
                            <div class="bg-white p-4 rounded shadow-lg text-center d-flex flex-column align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="200" width="200" viewBox="0 0 200 200" class="mb-3">
                                    <defs>
                                        <clipPath id="pencil-eraser">
                                            <rect height="30" width="30" ry="5" rx="5"></rect>
                                        </clipPath>
                                    </defs>
                                    <circle transform="rotate(-113,100,100)" stroke-linecap="round" stroke-dashoffset="439.82"
                                            stroke-dasharray="439.82 439.82" stroke-width="2" stroke="currentColor" fill="none"
                                            r="70" class="pencil__stroke"></circle>
                                    <g transform="translate(100,100)" class="pencil__rotate">
                                        <g fill="none">
                                            <circle transform="rotate(-90)" stroke-dashoffset="402" stroke-dasharray="402.12 402.12"
                                                    stroke-width="30" stroke="hsl(223,90%,50%)" r="64" class="pencil__body1"></circle>
                                            <circle transform="rotate(-90)" stroke-dashoffset="465" stroke-dasharray="464.96 464.96"
                                                    stroke-width="10" stroke="hsl(223,90%,60%)" r="74" class="pencil__body2"></circle>
                                            <circle transform="rotate(-90)" stroke-dashoffset="339" stroke-dasharray="339.29 339.29"
                                                    stroke-width="10" stroke="hsl(223,90%,40%)" r="54" class="pencil__body3"></circle>
                                        </g>
                                        <g transform="rotate(-90) translate(49,0)" class="pencil__eraser">
                                            <g class="pencil__eraser-skew">
                                                <rect height="30" width="30" ry="5" rx="5" fill="hsl(223,90%,70%)"></rect>
                                                <rect clip-path="url(#pencil-eraser)" height="30" width="5" fill="hsl(223,90%,60%)"></rect>
                                                <rect height="20" width="30" fill="hsl(223,10%,90%)"></rect>
                                                <rect height="20" width="15" fill="hsl(223,10%,70%)"></rect>
                                                <rect height="20" width="5" fill="hsl(223,10%,80%)"></rect>
                                                <rect height="2" width="30" y="6" fill="hsla(223,10%,10%,0.2)"></rect>
                                                <rect height="2" width="30" y="13" fill="hsla(223,10%,10%,0.2)"></rect>
                                            </g>
                                        </g>
                                        <g transform="rotate(-90) translate(49,-30)" class="pencil__point">
                                            <polygon points="15 0,30 30,0 30" fill="hsl(33,90%,70%)"></polygon>
                                            <polygon points="15 0,6 30,0 30" fill="hsl(33,90%,50%)"></polygon>
                                            <polygon points="15 0,20 10,10 10" fill="hsl(223,10%,10%)"></polygon>
                                        </g>
                                    </g>
                                </svg>

                                <p class="text-dark fw-semibold mt-2">Đang import dữ liệu, vui lòng chờ...</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!is_null($userResults) && !$hasImported)
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
                                        @if($user->isMemberOfOrganization($user->id, auth()->user()->id))
                                            <div class="rbt-button-group justify-content-end">
                                                <button
                                                    class="rbt-btn btn-xs bg-color-danger-opacity radius-round color-danger"
                                                    data-confirm="Bạn có chắc muốn xóa {{ $user->name }} này?"
                                                    wire:click.prevent="deleteMember({{ $user->id }})">
                                                    <i class="feather-trash-2 pl--0"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="rbt-button-group justify-content-end">
                                                <button class="rbt-btn btn-xs bg-primary-opacity radius-round"
                                                        data-confirm="Ban có chắc muốn thêm {{ $user->name }} này?"
                                                        wire:click.prevent="addMember({{ $user->id }})">
                                                    <i class="feather-user-plus pl--0"></i>
                                                </button>
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
    <template x-teleport="body">
        <div class="rbt-team-modal modal fade rbt-modal-default"
             id="importUser"
             tabindex="-1"
             aria-labelledby="importUser"
             data-bs-focus="true"
             wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                class="rbt-round-btn"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="inner">
                            <div x-data="{ isOver: false, fileName: '' }">
                                <form class="file-upload-form">
                                    <label class="file-upload-label">
                                        <div
                                            class="file-upload-design dropzone"
                                            :class="isOver ? 'dropzone--over' : ''"
                                            @dragover.prevent="isOver = true"
                                            @dragleave.prevent="isOver = false"
                                            @drop.prevent="
                                                isOver = false;
                                                const files = $event.dataTransfer.files;
                                                if (files && files.length) {
                                                    $refs.fileInput.files = files;
                                                    fileName = files[0].name;
                                                    $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                                                }
                                            ">
                                            <svg viewBox="0 0 640 512" height="1em">
                                                <path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"></path>
                                            </svg>

                                            <template x-if="!fileName">
                                                <div class="text-center">
                                                    <p>Drag and Drop</p>
                                                    <p>or</p>
                                                    <span class="browse-button">Browse file</span>
                                                </div>
                                            </template>
                                            <template x-if="fileName">
                                                <p class="mt-2" x-text="fileName"></p>
                                            </template>
                                        </div>

                                        <input
                                            id="file"
                                            x-ref="fileInput"
                                            wire:model="importUsersFile"
                                            type="file"
                                            accept=".xlsx,.csv,.xls"
                                            class="d-none"
                                            @change="fileName = $refs.fileInput.files?.[0]?.name || ''"
                                        />
                                    </label>
                                </form>
                            </div>

                            <div class="top-circle-shape"></div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <a class="rbt-btn-link"
                           href="{{ asset('excel_file/SampleImportMember.xlsx') }}"
                           download>
                            Download sample template
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 48 48">
                                    <defs>
                                        <linearGradient id="G7C1BuhajJQaEWHVlNUzHa_BEMhRoRy403e_gr1" x1="6" x2="27" y1="24" y2="24" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-color="#21ad64"></stop>
                                            <stop offset="1" stop-color="#088242"></stop>
                                        </linearGradient>
                                    </defs>
                                    <path fill="#31c447" d="m41,10h-16v28h16c.55,0,1-.45,1-1V11c0-.55-.45-1-1-1Z"></path>
                                    <path fill="#fff" d="m32,15h7v3h-7v-3Zm0,10h7v3h-7v-3Zm0,5h7v3h-7v-3Zm0-10h7v3h-7v-3Zm-7-5h5v3h-5v-3Zm0,10h5v3h-5v-3Zm0,5h5v3h-5v-3Zm0-10h5v3h-5v-3Z"></path>
                                    <path fill="url(#G7C1BuhajJQaEWHVlNUzHa_BEMhRoRy403e_gr1)" d="m27,42l-21-4V10l21-4v36Z"></path>
                                    <path fill="#fff" d="m19.13,31l-2.41-4.56c-.09-.17-.19-.48-.28-.94h-.04c-.05.22-.15.54-.32.98l-2.42,4.52h-3.76l4.46-7-4.08-7h3.84l2,4.2c.16.33.3.73.42,1.18h.04c.08-.27.22-.68.44-1.22l2.23-4.16h3.51l-4.2,6.94,4.32,7.06h-3.74Z"></path>
                                </svg>
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('import-finished', () => {
                const modalEl = document.getElementById('importUser');
                window.bootstrap?.Modal?.getOrCreateInstance(modalEl)?.hide();

                const fileInput = modalEl?.querySelector('#file');
                if (fileInput) {
                    fileInput.value = null;
                    fileInput.dispatchEvent(new Event('change', {bubbles: true}));
                }

                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
            });
        });

    </script>
@endpush
