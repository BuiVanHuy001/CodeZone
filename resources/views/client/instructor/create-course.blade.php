@section('custom-js')
    <script src="{{ asset('js/vendor/isotop.js') }}"></script>
    <script src="{{ asset('js/vendor/imageloaded.js') }}"></script>
    <script src="{{ asset('js/vendor/wow.js') }}"></script>
    <script src="{{ asset('js/vendor/waypoint.min.js') }}"></script>
@endsection

<x-base page-title="Create Course">
    <main class="rbt-main-wrapper">
        <div class="rbt-create-course-area bg-color-white rbt-section-gap">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
                            <div class="accordion" id="tutionaccordionExamplea1">
                                <div class="accordion-item card">
                                    <h2 class="accordion-header card-header" id="accOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#accCollapseOne" aria-expanded="true" aria-controls="accCollapseOne">
                                            Course Info
                                        </button>
                                    </h2>
                                    <div id="accCollapseOne" class="accordion-collapse collapse show" aria-labelledby="accOne"
                                         data-bs-parent="#tutionaccordionExamplea1">
                                        <div class="accordion-body card-body">
                                            <div class="rbt-course-field-wrapper rbt-default-form">
                                                <livewire:title-input-slug/>

                                                <div class="course-field mb--15">
                                                    <label>About Course</label>

                                                    <div id="editor"></div>
                                                    <small class="d-block mt-3"><i class="feather-info"></i> HTML or
                                                        plain text allowed, no emoji This field is used for search, so
                                                        please be descriptive!</small>
                                                </div>

                                                <div class="course-field mb--15 edu-bg-gray">
                                                    <h6>Course Settings</h6>
                                                    <div class="rbt-course-settings-content">
                                                        <div class="row g-5">
                                                            <div class="col-lg-4">
                                                                <div class="advance-tab-button advance-tab-button-1">
                                                                    <ul class="rbt-default-tab-button nav nav-tabs" id="courseSetting"
                                                                        role="tablist">
                                                                        <li class="nav-item" role="presentation">
                                                                            <a href="#" class="active" id="general-tab"
                                                                               data-bs-toggle="tab" data-bs-target="#general"
                                                                               role="tab" aria-controls="general" aria-selected="true">
                                                                                <span>General</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="tab-content">
                                                                    <div class="tab-pane fade advance-tab-content-1 active show"
                                                                         id="general" role="tabpanel" aria-labelledby="general-tab">
                                                                        <div class="course-field mb--20">
                                                                            <label for="field-4">Difficulty
                                                                                Level</label>
                                                                            <div class="rbt-modern-select bg-transparent height-45 mb--10">
                                                                                <select class="w-100" id="field-4">
                                                                                    <option>All Levels</option>
                                                                                    @foreach (App\Models\Course::$LEVELS as $level)
                                                                                        <option value="{{ $level }}">
                                                                                            {{ ucfirst($level) }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <small><i class="feather-info"></i> Course
                                                                                difficulty
                                                                                level</small>
                                                                        </div>

                                                                        <div class="course-field mb--20">
                                                                            <label for="field-4">Categories</label>
                                                                            <div class="rbt-modern-select bg-transparent height-45 mb--10">
                                                                                <select class="w-100" id="field-4">
                                                                                    <option>All Levels</option>
                                                                                    @foreach (App\Models\Category::parents() as $category)
                                                                                        @foreach ($category->getChildren($category->id) as $children)
                                                                                            <option value="{{ $children->id }}">
                                                                                                {{ $category->name . '->' . $children->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <small><i class="feather-info"></i> Course
                                                                                difficulty
                                                                                level</small>
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
                                                                    <ul class="rbt-default-tab-button nav nav-tabs" id="coursePrice"
                                                                        role="tablist">
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" class="active" id="paid-tab"
                                                                               data-bs-toggle="tab" data-bs-target="#paid" role="tab"
                                                                               aria-controls="paid" aria-selected="true">
                                                                                <span>Paid</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" id="free-tab" data-bs-toggle="tab"
                                                                               data-bs-target="#free" role="tab" aria-controls="free"
                                                                               aria-selected="false">
                                                                                <span>Free</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="tab-content">

                                                                    <div class="tab-pane fade advance-tab-content-1 active show"
                                                                         id="paid" role="tabpanel" aria-labelledby="paid-tab">

                                                                        <div class="course-field mb--15">
                                                                            <label for="regularPrice-1">Regular Price
                                                                                ($)</label>
                                                                            <input id="regularPrice-1" type="number"
                                                                                   placeholder="$ Regular Price">
                                                                            <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                                                                The Course
                                                                                Price Includes Your Author Fee.</small>
                                                                        </div>

                                                                        <div class="course-field mb--15">
                                                                            <label for="discountedPrice-1">Discounted
                                                                                Price ($)</label>
                                                                            <input id="discountedPrice-1" type="number"
                                                                                   placeholder="$ Discounted Price">
                                                                            <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                                                                The Course
                                                                                Price Includes Your Author Fee.</small>
                                                                        </div>

                                                                    </div>


                                                                    <div class="tab-pane fade advance-tab-content-1" id="free"
                                                                         role="tabpanel" aria-labelledby="free-tab">
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
                                                    <h6>Course Thumbnail</h6>
                                                    <div class="rbt-create-course-thumbnail upload-area">
                                                        <div class="upload-area">
                                                            <div class="brows-file-wrapper" data-black-overlay="9">
                                                                <input name="createinputfile" id="createinputfile" type="file"
                                                                       class="inputfile"/>
                                                                <img id="createfileImage"
                                                                     src="{{ asset('images/others/thumbnail-placeholder.svg') }}"
                                                                     alt="file image">
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
                                    <h2 class="accordion-header card-header" id="accThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseThree" aria-expanded="false" aria-controls="accCollapseThree">
                                            Course Builder
                                        </button>
                                    </h2>
                                    <div id="accCollapseThree" class="accordion-collapse collapse" aria-labelledby="accThree">
                                        <div class="accordion-body card-body">
                                            <div class="accordion-item card mb--20 p-3">
                                                <label for="import-file" class="form-label fw-bold">Import Course
                                                    Structure</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div>
                                                        <input type="file" id="import-file" class="form-control" accept=".xlsx,.csv,.xls,.json" style="display: none;">
                                                        <button type="button" onclick="document.getElementById('import-file').click()" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                                            <span class="icon-reverse-wrapper">
                                                                <span class="btn-text">Accepted formats: .xlsx, .csv, .json</span>
                                                                <span class="btn-icon"><i class="feather-download"></i></span>
                                                                <span class="btn-icon"><i class="feather-download"></i></span>
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <div>
                                                        <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                                            <span class="icon-reverse-wrapper">
                                                                <span class="btn-text">Download Sample File</span>
                                                                <span class="btn-icon"><i class="feather-download"></i></span>
                                                                <span class="btn-icon"><i class="feather-download"></i></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <livewire:module-builder/>

                                            <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#accCollapseSix" aria-expanded="false" aria-controls="accCollapseSix">
                                            Additional Information
                                        </button>
                                    </h2>
                                    <div id="accCollapseSix" class="accordion-collapse collapse" aria-labelledby="accSix"
                                         data-bs-parent="#tutionaccordionExamplea1">
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
                                                        <select class="w-100" data-live-search="true" title="English" multiple
                                                                data-size="7" data-actions-box="true" data-selected-text-format="count > 2"
                                                                id="language">
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
                                                            <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                                                Hour.</small>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="number" placeholder="00">
                                                            <small class="d-block mt_dec--5"><i class="feather-info"></i>
                                                                Minute.</small>
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
                                                        Keywords should all be
                                                        in lowercase and separated by commas. e.g. photography, gallery,
                                                        modern, jquery,
                                                        wordpress theme.</small>
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
                                                        Specify the target audience that will benefit the most from the
                                                        course.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt--10 row g-5">
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
                    </div>

                    <div class="col-lg-4">
                        <div class="rbt-create-course-sidebar course-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                            <div class="inner">
                                <div class="section-title mb--30">
                                    <h4 class="title">Course Upload Tips</h4>
                                </div>
                                <div class="rbt-course-upload-tips">
                                    <ul class="rbt-list-style-1">
                                        <li><i class="feather-check"></i> Set the Course Price option or make it free.
                                        </li>
                                        <li><i class="feather-check"></i> Standard size for the course thumbnail is
                                            700x430.
                                        </li>
                                        <li><i class="feather-check"></i> Video section controls the course overview
                                            video.
                                        </li>
                                        <li><i class="feather-check"></i> Course Builder is where you create & organize
                                            a course.
                                        </li>
                                        <li><i class="feather-check"></i> Add Topics in the Course Builder section to
                                            create lessons, quizzes, and assignments.
                                        </li>
                                        <li><i class="feather-check"></i> Prerequisites refers to the fundamental
                                            courses to complete before taking this particular course.
                                        </li>
                                        <li><i class="feather-check"></i> Information from the Additional Data section
                                            shows up on the course single page.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-base>


