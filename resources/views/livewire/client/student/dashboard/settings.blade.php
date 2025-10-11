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
                    </div>

                    @if ($isDirty)
                        <div class="col-12 mt--20">
                            <div class="rbt-form-group">
                                <button wire:click.prevent="cancel" class="rbt-btn btn-border btn-sm">Cancel</button>
                                <a wire:click.prevent="save" class="rbt-btn btn-gradient btn-sm" href="#">Save</a>
                            </div>
                        </div>
                    @endif
                </form>
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
</div>
