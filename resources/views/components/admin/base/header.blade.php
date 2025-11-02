<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box horizontal-logo">
                    <a href="" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22"/>
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="17"/>
                        </span>
                    </a>

                    <a href="" class="logo logo-light">
                  <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="" height="22"/>
                  </span>
                        <span class="logo-lg">
                    <img
                        src="assets/images/logo-light.png"
                        alt=""
                        height="17"
                    />
                  </span>
                    </a>
                </div>

                <button
                    type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon"
                >
                <span class="hamburger-icon">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
                </button>

                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search..."
                            autocomplete="off"
                            id="search-options"
                            value=""
                        />
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span
                            class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"
                        ></span>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button
                        type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-search-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown"
                    >
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Search ..."
                                        aria-label="Recipient's username"
                                    />
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button
                        type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <img
                            id="header-lang-img"
                            src="{{ asset('images/flags/us.svg') }}"
                            alt="Header Language"
                            height="20"
                            class="rounded"
                        />
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a
                            href="javascript:void(0);"
                            class="dropdown-item notify-item language py-2"
                            data-lang="en"
                            title="English"
                        >
                            <img
                                src="{{ asset('images/flags/us.svg') }}"
                                alt="user-image"
                                class="me-2 rounded"
                                height="18"
                            />
                            <span class="align-middle">English</span>
                        </a>

                        <a
                            href="javascript:void(0);"
                            class="dropdown-item notify-item language"
                            data-lang="sp"
                            title="Spanish"
                        >
                            <img
                                src="{{ asset('images/flags/spain.svg') }}"
                                alt="user-image"
                                class="me-2 rounded"
                                height="18"
                            />
                            <span class="align-middle">Española</span>
                        </a>

                        <a
                            href="javascript:void(0);"
                            class="dropdown-item notify-item language"
                            data-lang="gr"
                            title="German"
                        >
                            <img
                                src="{{ asset('images/flags/germany.svg') }}"
                                alt="user-image"
                                class="me-2 rounded"
                                height="18"
                            />
                            <span class="align-middle">Deutsche</span>
                        </a>

                        <a
                            href="javascript:void(0);"
                            class="dropdown-item notify-item language"
                            data-lang="it"
                            title="Italian"
                        >
                            <img
                                src="{{ asset('images/flags/italy.svg') }}"
                                alt="user-image"
                                class="me-2 rounded"
                                height="18"
                            />
                            <span class="align-middle">Italiana</span>
                        </a>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button
                        type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen"
                    >
                        <i class="bx bx-fullscreen fs-22"></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class="bx bx-moon fs-22"></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            aria-haspopup="true"
                            aria-expanded="false">
                        <i class="bx bx-bell fs-22"></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                    </button>

                    <div
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown"
                    >
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">
                                            Notifications
                                        </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                          <span class="badge bg-light-subtle text-body fs-13">
                            4 New</span
                          >
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul
                                    class="nav nav-tabs dropdown-tabs nav-tabs-custom"
                                    data-dropdown-tabs="true"
                                    id="notificationItemsTab"
                                    role="tablist"
                                >
                                    <li class="nav-item waves-effect waves-light">
                                        <a
                                            class="nav-link active"
                                            data-bs-toggle="tab"
                                            href="#all-noti-tab"
                                            role="tab"
                                            aria-selected="true"
                                        >
                                            All (4)
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a
                                            class="nav-link"
                                            data-bs-toggle="tab"
                                            href="#messages-tab"
                                            role="tab"
                                            aria-selected="false"
                                        >
                                            Messages
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a
                                            class="nav-link"
                                            data-bs-toggle="tab"
                                            href="#alerts-tab"
                                            role="tab"
                                            aria-selected="false"
                                        >
                                            Alerts
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="tab-content position-relative"
                            id="notificationItemsTabContent"
                        >
                            <div
                                class="tab-pane fade show active py-2 ps-2"
                                id="all-noti-tab"
                                role="tabpanel"
                            >
                                <div
                                    data-simplebar
                                    style="max-height: 300px"
                                    class="pe-2"
                                >
                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative"
                                    >
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                              <span
                                  class="avatar-title bg-info-subtle text-info rounded-circle fs-16"
                              >
                                <i class="bx bx-badge-check"></i>
                              </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">
                                                        Your <b>Elite</b> author Graphic Optimization
                                                        <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> Just 30
                                  sec ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="all-notification-check01"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="all-notification-check01"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-2.jpg"
                                                class="me-3 rounded-circle avatar-xs flex-shrink-0"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Angela Bernier
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Answered to your comment on the cash flow
                                                        forecast's graph 🔔.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 48 min
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="all-notification-check02"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="all-notification-check02"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative"
                                    >
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                              <span
                                  class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16"
                              >
                                <i class="bx bx-message-square-dots"></i>
                              </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 fs-13 lh-base">
                                                        You have received
                                                        <b class="text-success">20</b> new messages in
                                                        the conversation
                                                    </h6>
                                                </a>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 2 hrs
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="all-notification-check03"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="all-notification-check03"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-8.jpg"
                                                class="me-3 rounded-circle avatar-xs flex-shrink-0"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Maureen Gibson
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 4 hrs
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="all-notification-check04"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="all-notification-check04"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button
                                            type="button"
                                            class="btn btn-soft-success waves-effect waves-light"
                                        >
                                            View All Notifications
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="tab-pane fade py-2 ps-2"
                                id="messages-tab"
                                role="tabpanel"
                                aria-labelledby="messages-tab"
                            >
                                <div
                                    data-simplebar
                                    style="max-height: 300px"
                                    class="pe-2"
                                >
                                    <div
                                        class="text-reset notification-item d-block dropdown-item"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-3.jpg"
                                                class="me-3 rounded-circle avatar-xs"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        James Lemire
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 30 min
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="messages-notification-check01"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="messages-notification-check01"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-2.jpg"
                                                class="me-3 rounded-circle avatar-xs"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Angela Bernier
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Answered to your comment on the cash flow
                                                        forecast's graph 🔔.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 2 hrs
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="messages-notification-check02"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="messages-notification-check02"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-6.jpg"
                                                class="me-3 rounded-circle avatar-xs"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Kenneth Brown
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Mentionned you in his comment on 📃 invoice
                                                        #12501.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 10 hrs
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="messages-notification-check03"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="messages-notification-check03"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item"
                                    >
                                        <div class="d-flex">
                                            <img
                                                src="assets/images/users/avatar-8.jpg"
                                                class="me-3 rounded-circle avatar-xs"
                                                alt="user-pic"
                                            />
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Maureen Gibson
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p
                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                >
                                <span
                                ><i class="mdi mdi-clock-outline"></i> 3 days
                                  ago</span
                                >
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value=""
                                                        id="messages-notification-check04"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="messages-notification-check04"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button
                                            type="button"
                                            class="btn btn-soft-success waves-effect waves-light"
                                        >
                                            View All Messages
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="tab-pane fade p-4"
                                id="alerts-tab"
                                role="tabpanel"
                                aria-labelledby="alerts-tab"
                            ></div>

                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select
                                    <div
                                        id="select-content"
                                        class="text-body fw-semibold px-1"
                                    >
                                        0
                                    </div>
                                    Result
                                    <button
                                        type="button"
                                        class="btn btn-link link-danger p-0 ms-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#removeNotificationModal"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button
                        type="button"
                        class="btn"
                        id="page-header-user-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{ Vite::asset('resources/assets/admin/images/users/avatar-1.jpg') }}"
                                 alt="Header Avatar"
                            />
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Anna Adame</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Founder</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Profile</span>
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Messages</span>
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Taskboard</span>
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Help</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Balance : <b>$5971.67</b></span>
                        </a>
                        <a class="dropdown-item" href="">
                            <span class="badge bg-success-subtle text-success mt-1 float-end">New</span>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Lock screen</span>
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
