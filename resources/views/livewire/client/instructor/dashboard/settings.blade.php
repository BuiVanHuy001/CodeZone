<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">

        <div class="section-title">
            <h4 class="rbt-title-style-3">Settings</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="settinsTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" @class([
                            'tab-button',
                            'active' => $activeTab === 'profile'
                        ])
                    x-on:click="$wire.activeTab = 'profile'"
                       id="profile-tab" data-bs-toggle="tab"
                       data-bs-target="#profile" role="tab" aria-controls="profile" aria-selected="true">
                        <span class="title">Profile</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" @class([
                            'tab-button',
                            'active' => $activeTab === 'password'
                       ])
                    x-on:click="$wire.activeTab = 'password'"
                       id="password-tab" data-bs-toggle="tab"
                       data-bs-target="#password" role="tab" aria-controls="password" aria-selected="false">
                        <span class="title">Password</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div aria-labelledby="profile-tab" @class([
                    'tab-pane fade',
                    'active show' => $activeTab === 'profile'
                ])
            id="profile" role="tabpanel">
                <div class="rbt-dashboard-content-wrapper">
                    <div class="rbt-dashboard-content-wrapper">
                        <div class="thumbnail rbt-avatars size-lg position-relative">
                            <img src="{{ auth()->user()->getAvatarPath() }}" alt="Instructor">
                            <div class="rbt-edit-photo-inner">
                                <button class="rbt-edit-photo" title="Upload Photo">
                                    <i class="feather-camera"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <form class="rbt-profile-row rbt-default-form row row--15">
                        <div class="col-12 row mb-3">
                            <h5>Basic info</h5>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="firstname">Full Name</label>
                                    <input class="disabled" id="firstname" type="text" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="lastname">Email</label>
                                    <input class="disabled" id="lastname" type="text" value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="rbt-form-group">
                                    <label for="bio">About me</label>
                                    <textarea cols="20" rows="5" wire:model.lazy="aboutMe">{{ $aboutMe }}</textarea>
                                    <small style="margin-top: -5px; display: block"><i class="feather-info"></i> A brief
                                        description about yourself.</small>
                                </div>
                            </div>

                            <x-client.dashboard.inputs.markdown-area
                                id="bio-editor"
                                label="Biography"
                                name="bio"
                                :isError="$errors->has('bio')"
                                info="This will be displayed on your public profile. Markdown is supported."
                                :livewireComponentId="$this->getId()"
                                :doc="$bio"
                            />
                        </div>

                        <div class="col-12 row">
                            <h5>Social accounts</h5>
                            <div class="col-4">
                                <div class="rbt-form-group">
                                    <label for="facebook">Facebook</label>
                                    <input wire:model.blur="socialLinks.facebook" id="facebook" type="url" placeholder="https://facebook.com/">
                                    @if(isset($socialLinks['facebook']))
                                        <small class="d-block mb-3" style="margin-top: -15px">
                                            <a href="https://facebook.com/{{ $socialLinks['facebook'] }}" target="_blank"><i class="feather-facebook"></i>/{{ $socialLinks['facebook'] }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rbt-form-group">
                                    <label for="linkedin">Linkedin</label>
                                    <input wire:model.blur="socialLinks.linkedin" id="linkedin" type="url" placeholder="https://linkedin.com/">
                                    @if(isset($socialLinks['linkedin']))
                                        <small class="d-block mb-3" style="margin-top: -15px">
                                            <a href="https://linkedin.com/{{ $socialLinks['linkedin'] }}" target="_blank"><i class="feather-linkedin"></i>/{{ $socialLinks['linkedin'] }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rbt-form-group">
                                    <label for="website">Website</label>
                                    <input wire:model.blur="socialLinks.website" id="website" type="url" placeholder="https://website.com/">
                                    @if(isset($socialLinks['website']))
                                        <small class="d-block mb-3" style="margin-top: -15px">
                                            <a href="https://{{ $socialLinks['website'] }}" target="_blank"><i class="feather-globe"></i>{{ $socialLinks['website'] }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rbt-form-group">
                                    <label for="github"><i class="feather-github"></i> Github</label>
                                    <input wire:model.blur="socialLinks.github" id="github" type="url" placeholder="https://github.com/">
                                    @if(isset($socialLinks['github']))
                                        <small class="d-block mb-3" style="margin-top: -15px">
                                            <i class="feather-link"></i> Link:
                                            <a href="https://github.com/{{ $socialLinks['github'] }}" target="_blank" wire:text="socialLinks.github"></a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="rbt-form-group">
                                    <label for="youtube"><i class="feather-youtube"></i> Youtube</label>
                                    <input wire:model.blur="socialLinks.youtube" id="youtube" type="url" placeholder="https://www.youtube.com/">
                                    @if (isset($socialLinks['youtube']))
                                        <small class="d-block mb-3" style="margin-top: -15px">
                                            <i class="feather-link"></i> Link:
                                            <a href="https://www.youtube.com/{{ $socialLinks['youtube'] }}" target="_blank" wire:text="socialLinks.youtube"></a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($isDirty)
                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <button onclick="confirmCancel()" class="rbt-btn btn-border btn-sm">Cancel</button>
                                    <a wire:click.prevent="save" class="rbt-btn btn-gradient btn-sm" href="#">Save</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div aria-labelledby="password-tab" @class([
                    'tab-pane fade',
                    'active show' => $activeTab === 'password'
                  ])
            id="password" role="tabpanel">
                <form class="rbt-profile-row rbt-default-form row row--15">
                    <x-client.dashboard.inputs.text
                        model="password.current"
                        label="Current Password"
                        type="password"
                        placeholder="Enter your current password"
                        name="password.current"
                        info="Please enter the password you currently use."
                    />

                    <x-client.dashboard.inputs.text
                        model="password.new"
                        label="New Password"
                        type="password"
                        placeholder="Enter a new password"
                        name="password.new"
                        info="Your new password must be at least 8 characters."
                    />

                    <x-client.dashboard.inputs.text
                        model="password.confirmation"
                        label="Confirm New Password"
                        type="password"
                        placeholder="Re-enter your new password"
                        name="password.confirmation"
                        info="Re-enter your new password to confirm."
                    />

                    <span class="text-end"><a class="rbt-btn-link cursor-pointer" wire:click.prevent="forgotPassword">Forgot your password ?</a></span>

                    <div class="col-12 mt--10">
                        <div class="rbt-form-group">
                            <button wire:click.prevent="changePassword" class="rbt-btn btn-gradient">Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmCancel() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Your changes will be lost if you cancel.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.
                        call('cancel');
                    }
                });
            }
        </script>
@endpush
