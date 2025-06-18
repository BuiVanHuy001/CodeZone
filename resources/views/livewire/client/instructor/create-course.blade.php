<div>
    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
        <div class="accordion" id="tutionaccordionExamplea1">
            <div class="accordion-item card">
                <h2 class="accordion-header card-header" id="accOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseOne" aria-expanded="true" aria-controls="accCollapseOne">
                        Course Info
                    </button>
                </h2>
                <div id="accCollapseOne" class="accordion-collapse collapse show" aria-labelledby="accOne" data-bs-parent="#tutionaccordionExamplea1">
                    <div class="accordion-body card-body">
                        <div class="rbt-course-field-wrapper rbt-default-form">
                            <div class="course-field mb--15">
                                <label for="field-1">Course Title</label>
                                <input id="field-1" type="text" placeholder="Enter your course name" wire:model.live.debounce.450ms="title">
{{--                                <small class="d-block mt_dec--5 mb-3"><i class="feather-info"></i> Title should be 30 character.</small>--}}
                                <small class="d-block mt_dec--5" wire:model="slug"><i class="feather-info"></i>Permalink: https://codezone.com/course/{{ $slug }}</small>
                            </div>

                            <div class="course-field mb--15">
                                <label for="aboutCourse">About Course</label>
                                <textarea id="editor" rows="10"></textarea>
                                <small class="d-block mt_dec--5"><i class="feather-info"></i> HTML or plain text allowed, no emoji This field is used for search, so please be descriptive!</small>
                            </div>

                            <div class="course-field mb--15 edu-bg-gray">
                                <h6>Course Settings</h6>
                                <div class="rbt-course-settings-content">
                                    <div class="row g-5">
                                        <div class="col-lg-4">
                                            <div class="advance-tab-button advance-tab-button-1">
                                                <ul class="rbt-default-tab-button nav nav-tabs" id="courseSetting" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a href="#" class="active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">
                                                            <span>General</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a href="#" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" role="tab" aria-controls="content" aria-selected="false">
                                                            <span>Content Drip</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="tab-content">
                                                <div class="tab-pane fade advance-tab-content-1 active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                                    <div class="course-field mb--20">
                                                        <label for="field-3">Maximum
                                                            Students</label>
                                                        <div class="pro-quantity">
                                                            <div class="pro-qty m-0">
                                                                <input id="field-3" type="text" value="100"></div>
                                                        </div>
                                                        <small><i class="feather-info"></i> Number
                                                            of students that can enrol in this
                                                            course. Set 0 for no limits.</small>
                                                    </div>

                                                    <div class="course-field mb--20">
                                                        <label for="field-4">Difficulty
                                                            Level</label>
                                                        <div class="rbt-modern-select bg-transparent height-45 mb--10">
                                                            <select class="w-100" id="field-4">
                                                                <option>All Levels</option>
                                                                <option>Intermediate</option>
                                                                <option>Beginner</option>
                                                                <option>Advance</option>
                                                                <option>Expert</option>
                                                            </select>
                                                        </div>
                                                        <small><i class="feather-info"></i> Course
                                                            difficulty level</small>
                                                    </div>

                                                    <div class="course-field mb--20">
                                                        <label class="form-check-label d-inline-block" for="flexSwitchCheckDefault">Public
                                                            Course</label>
                                                        <div class="form-check form-switch mb--10">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                        </div>
                                                        <small><i class="feather-info"></i> Make
                                                            This Course Public. No enrollment
                                                            required.</small>
                                                    </div>

                                                    <div class="course-field mb--20">
                                                        <label class="form-check-label d-inline-block" for="flexSwitchCheckDefault2">Q&A</label>
                                                        <div class="form-check form-switch mb--10">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault2">
                                                        </div>
                                                        <small><i class="feather-info"></i> Enable
                                                            Q&A section for your course</small>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade advance-tab-content-1" id="content" role="tabpanel" aria-labelledby="content-tab">
                                                    <div class="rbt-content-drip-content">
                                                        <div class="course-field pb--20">
                                                            <p class="rbt-checkbox-wrapper mb--5">
                                                                <input id="rbt-checkbox-1" name="rbt-checkbox-1" type="checkbox" value="yes">
                                                                <label for="rbt-checkbox-1">Enable</label>
                                                            </p>
                                                            <small><i class="feather-info"></i>
                                                                Enable / Disable content
                                                                drip</small>
                                                        </div>
                                                        <hr class="rbt-separator m-0">

                                                        <div class="rbt-course-drip-option pt--20">
                                                            <h6 class="mb--10">Content Drip Type
                                                            </h6>
                                                            <p class="mb--10 b3">You can schedule
                                                                your
                                                                course content using the above
                                                                content drip options.</p>
                                                            <div class="course-drop-option">
                                                                <div class="rbt-form-check">
                                                                    <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-1">
                                                                    <label class="form-check-label" for="rbt-radio-1">
                                                                        Schedule
                                                                        course contents by
                                                                        date</label>
                                                                </div>
                                                                <div class="rbt-form-check">
                                                                    <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-2">
                                                                    <label class="form-check-label" for="rbt-radio-2">
                                                                        Content
                                                                        available after X days from
                                                                        enrollment</label>
                                                                </div>
                                                                <div class="rbt-form-check">
                                                                    <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-3">
                                                                    <label class="form-check-label" for="rbt-radio-3">
                                                                        Course
                                                                        content available
                                                                        sequentially</label>
                                                                </div>
                                                                <div class="rbt-form-check">
                                                                    <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-4">
                                                                    <label class="form-check-label" for="rbt-radio-4">
                                                                        Course
                                                                        content unlocked after
                                                                        finishing
                                                                        prerequisites</label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="course-field mb--15 edu-bg-gray">
                                <h6>Course Price</h6>
                                <div class="rbt-course-settings-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="advance-tab-button advance-tab-button-1">
                                                <ul class="rbt-default-tab-button nav nav-tabs" id="coursePrice" role="tablist">
                                                    <li class="nav-item w-100" role="presentation">
                                                        <a href="#" class="active" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" role="tab" aria-controls="paid" aria-selected="true">
                                                            <span>Paid</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item w-100" role="presentation">
                                                        <a href="#" id="free-tab" data-bs-toggle="tab" data-bs-target="#free" role="tab" aria-controls="free" aria-selected="false">
                                                            <span>Free</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="tab-content">

                                                <div class="tab-pane fade advance-tab-content-1 active show" id="paid" role="tabpanel" aria-labelledby="paid-tab">

                                                    <div class="course-field mb--15">
                                                        <label for="regularPrice-1">Regular Price
                                                            ($)</label>
                                                        <input id="regularPrice-1" type="number" placeholder="$ Regular Price">
                                                        <small class="d-block mt_dec--5"><i
                                                                class="feather-info"></i> The Course
                                                            Price Includes Your Author Fee.</small>
                                                    </div>

                                                    <div class="course-field mb--15">
                                                        <label for="discountedPrice-1">Discounted
                                                            Price ($)</label>
                                                        <input id="discountedPrice-1" type="number" placeholder="$ Discounted Price">
                                                        <small class="d-block mt_dec--5"><i
                                                                class="feather-info"></i> The Course
                                                            Price Includes Your Author Fee.</small>
                                                    </div>

                                                </div>


                                                <div class="tab-pane fade advance-tab-content-1" id="free" role="tabpanel" aria-labelledby="free-tab">
                                                    <div class="course-field">
                                                        <p class="b3">This Course is free for
                                                            everyone.</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="course-field mb--20">
                                <h6>Choose Categories</h6>
                                <div class="rbt-modern-select bg-transparent height-45 w-100 mb--10">
                                    <select class="w-100" data-live-search="true" title="Search Course Category. ex. Design, Development, Business" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 2">
                                        <option>Web Developer</option>
                                        <option>App Developer</option>
                                        <option>Javascript</option>
                                        <option>React</option>
                                        <option>WordPress</option>
                                        <option>jQuery</option>
                                        <option>Vue Js</option>
                                        <option>Angular</option>
                                    </select>
                                </div>
                            </div>

                            <div class="course-field mb--20">
                                <h6>Course Thumbnail</h6>
                                <div class="rbt-create-course-thumbnail upload-area">
                                    <div class="upload-area">
                                        <div class="brows-file-wrapper" data-black-overlay="9">
                                            <input name="createinputfile" id="createinputfile" type="file" class="inputfile"/>
                                            <img id="createfileImage" src="{{ asset('images/others/thumbnail-placeholder.svg') }}" alt="file image">
                                            <label class="d-flex" for="createinputfile" title="No File Choosen">
                                                <i class="feather-upload"></i>
                                                <span class="text-center">Choose a File</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <small><i class="feather-info"></i> <b>Size:</b> 700x430 pixels,
                                    <b>File Support:</b> JPG, JPEG, PNG, GIF, WEBP</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item card">
                <h2 class="accordion-header card-header" id="accTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseTwo" aria-expanded="false" aria-controls="accCollapseTwo">
                        Course Intro Video
                    </button>
                </h2>
                <div id="accCollapseTwo" class="accordion-collapse collapse" aria-labelledby="accTwo" data-bs-parent="#tutionaccordionExamplea1">
                    <div class="accordion-body card-body rbt-course-field-wrapper rbt-default-form">

                        <div class="course-field mb--20">
                            <div class="rbt-modern-select bg-transparent height-45 mb--10">
                                <select class="w-100" id="field-5">
                                    <option value="" disabled selected>Select Video Sources</option>
                                    <option value="youtube">Youtube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="local">Local</option>
                                </select>
                            </div>
                        </div>

                        <div class="course-field mb--15">
                            <label for="videoUrl">Add Your Video URL</label>
                            <input id="videoUrl" type="text" placeholder="Add Your Video URL here.">
                            <small class="d-block mt_dec--5">Example: <a href="https://www.youtube.com/watch?v=yourvideoid">https://www.youtube.com/watch?v=yourvideoid</a></small>
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item card">
                <h2 class="accordion-header card-header" id="accThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseThree" aria-expanded="false" aria-controls="accCollapseThree">
                        Course Builder
                    </button>
                </h2>
                <div id="accCollapseThree" class="accordion-collapse collapse" aria-labelledby="accThree">
                    <div class="accordion-body card-body">
                        <div class="accordion-item card mb--20">
                            <h2 class="accordion-header card-header rbt-course" id="accOne1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseOne1" aria-expanded="false" aria-controls="accCollapseOne1">
                                    Lesson One
                                </button>
                                <span class="rbt-course-icon rbt-course-edit" data-bs-toggle="modal"
                                      data-bs-target="#UpdateTopic"></span><span
                                    class="rbt-course-icon rbt-course-del"></span>
                            </h2>
                            <div id="accCollapseOne1" class="accordion-collapse collapse" aria-labelledby="accOne1">
                                <div class="accordion-body card-body" id="dnd1">
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">The Complete Histudy 2024: From Zero to Expert!</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">Difficult Things About Education.</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">Five Things You Should Do In Education.</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">The Complete Histudy 2024: From Zero to Expert!</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li>
                                                    <i class="feather-trash"></i>
                                                </li>
                                                <li>
                                                    <i class="feather-edit" data-bs-toggle="modal" data-bs-target="#Quiz"></i>
                                                </li>
                                                <li>
                                                    <i class="feather-upload"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="gap-3 d-flex flex-wrap">
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Lesson">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Lesson</span>
                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                </span>
                                            </button>
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Quiz"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Quiz</span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span></span></button>
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Assignment"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Assignments </span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span></span></button>
                                        </div>
                                        <div class="mt-3 mt-md-0">
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Import Quiz </span><span
                                                        class="btn-icon"><i
                                                            class="feather-download"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-download"></i></span></span>
                                            </button>
                                            <input type="file" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item card mb--20">
                            <h2 class="accordion-header card-header rbt-course" id="accOne2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseOne2" aria-expanded="false" aria-controls="accCollapseOne2">
                                    Lesson
                                    two
                                </button>
                                <span class="rbt-course-icon rbt-course-edit" data-bs-toggle="modal"
                                      data-bs-target="#UpdateTopic"></span><span
                                    class="rbt-course-icon rbt-course-del"></span>
                            </h2>
                            <div id="accCollapseOne2" class="accordion-collapse collapse" aria-labelledby="accOne2">
                                <div class="accordion-body card-body" id="dnd2">
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">The Complete Histudy 2024:
                                                From Zero to Expert!</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">Difficult Things About
                                                Education.</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">Five Things You Should Do In
                                                Education.</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                        <div class="col-10 inner d-flex align-items-center gap-2"><i
                                                class="feather-menu cursor-scroll"></i>
                                            <h6 class="rbt-title mb-0">The Complete Histudy 2024:
                                                From Zero to Expert!</h6>
                                        </div>
                                        <div class="col-2 inner">
                                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                                <li><i class="feather-trash"></i></li>
                                                <li><i class="feather-edit" data-bs-toggle="modal"
                                                       data-bs-target="#Quiz"></i></li>
                                                <li><i class="feather-upload"></i></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="gap-3 d-flex flex-wrap">
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Lesson"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Lesson</span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span></span></button>
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Quiz"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Quiz</span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span></span></button>
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Assignment"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Assignments </span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-plus-square"></i></span></span></button>
                                        </div>
                                        <div class="mt-3 mt-md-0">
                                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"><span
                                                    class="icon-reverse-wrapper"><span
                                                        class="btn-text">Import Quiz </span><span
                                                        class="btn-icon"><i
                                                            class="feather-download"></i></span><span
                                                        class="btn-icon"><i
                                                            class="feather-download"></i></span></span>
                                            </button>
                                            <input type="file" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <span class="icon-reverse-wrapper">
                                                        <span class="btn-text">Add New Topic</span>
                                                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                                                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                                                    </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="accordion-item card rbt-course-field-wrapper">
                <h2 class="accordion-header card-header" id="accSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseSix" aria-expanded="false" aria-controls="accCollapseSix">
                        Additional Information
                    </button>
                </h2>
                <div id="accCollapseSix" class="accordion-collapse collapse" aria-labelledby="accSix" data-bs-parent="#tutionaccordionExamplea1">
                    <div class="accordion-body card-body rbt-course-field-wrapper rbt-default-form row row-15">

                        <div class="col-lg-6">
                            <div class="course-field mb--15">
                                <label for="startDate">Start Date</label>
                                <input type="date" id="startDate" name="startDate">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="course-field mb--15">
                                <label for="language">Language</label>
                                <div class="rbt-modern-select bg-transparent height-50 mb--10">
                                    <select class="w-100" data-live-search="true" title="English" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 2" id="language">
                                        <option>English</option>
                                        <option>Bangla</option>
                                        <option>Japan</option>
                                        <option>Hindi</option>
                                        <option>Frence</option>
                                        <option>Garmani</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="course-field mb--15">
                                <label for="whatLearn">Requirements</label>
                                <textarea id="whatLearn" rows="5" placeholder="Add your course benefits here."></textarea>
                                <small class="d-block mt_dec--5"><i class="feather-info"></i> Enter
                                    for per line.</small>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="course-field mb--15">
                                <label for="description">Description</label>
                                <textarea id="description" rows="5" placeholder="Add your course benefits here."></textarea>
                                <small class="d-block mt_dec--5"><i class="feather-info"></i> Enter
                                    for per line.</small>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr class="mt--10 mb--20">
                        </div>

                        <div class="col-lg-12">
                            <div class="course-field mb--15">
                                <label>Total Course Duration</label>
                                <div class="row row--15">
                                    <div class="col-lg-6">
                                        <input type="number" placeholder="00">
                                        <small class="d-block mt_dec--5"><i
                                                class="feather-info"></i> Hour.</small>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="number" placeholder="00">
                                        <small class="d-block mt_dec--5"><i
                                                class="feather-info"></i> Minute.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr class="mt--10 mb--20">
                        </div>

                        <div class="col-lg-12">
                            <div class="course-field mb--15">
                                <label for="courseTag">Course Tags</label>
                                <textarea id="courseTag" rows="5" placeholder="Add your course tag here."></textarea>
                                <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                    Maximum of 15 keywords covering features, usage, and styling.
                                    Keywords should all be in lowercase and separated by commas.
                                    e.g. photography, gallery, modern, jquery, wordpress
                                    theme.</small>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr class="mt--10 mb--20">
                        </div>

                        <div class="col-lg-12">
                            <div class="course-field mb--15">
                                <label for="targeted">Targeted Audience</label>
                                <textarea id="targeted" rows="5" placeholder="Add your course tag here."></textarea>
                                <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                    Specify the target audience that will benefit the most from the course.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt--10 row g-5">
    </div>

    <div class="col-lg-4">
        <a class="rbt-btn hover-icon-reverse bg-primary-opacity w-100 text-center" href="">
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Preview</span>
                <span class="btn-icon"><i class="feather-eye"></i></span>
                <span class="btn-icon"><i class="feather-eye"></i></span>
            </span>
        </a>
    </div>
    <div class="col-lg-8">
        <a class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center" href="#">
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Create Course</span>
                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
            </span>
        </a>
    </div>
</div>
