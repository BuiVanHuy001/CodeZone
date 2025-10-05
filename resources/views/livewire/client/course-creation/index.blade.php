<main class="rbt-main-wrapper">
    <div class="rbt-create-course-area bg-color-white rbt-section-gap position-relative">
        <a class="rbt-btn btn-gradient btn-sm hover-icon-reverse position-absolute"
           style="top: 10px; right: 10px"
           href="javascript:void(0);"
           onclick="window.history.back();"
        >
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Go back</span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
            </span>
        </a>
        <div class="container">
            <div class="row">
                <form>
                    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
                        <div class="accordion" id="courseCreation">
                            <div @class([
                                   'accordion-item card',
                                   'border border-danger' => $errors->hasAny(['title', 'heading', 'description', 'category', 'level', 'price', 'startDate', 'endDate', 'image']),
                                ]) >
                                <h2 class="accordion-header card-header" id="accInfo">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accCollapseInfo"
                                        aria-expanded="true"
                                        aria-controls="accCollapseInfo">
                                        Course Info
                                    </button>
                                </h2>
                                <div wire:ignore.self
                                     id="accCollapseInfo"
                                     class="accordion-collapse collapse show"
                                     aria-labelledby="accInfo"
                                     data-bs-parent="#courseCreation">
                                    <div class="accordion-body card-body">
                                        <div class="rbt-course-field-wrapper rbt-default-form">
                                            <x-client.dashboard.inputs.text
                                                model="title"
                                                name="title"
                                                label="Course Title"
                                                placeholder="Enter course title"
                                                :$slug
                                            />

                                            <x-client.dashboard.inputs.text
                                                model="heading"
                                                name="heading"
                                                label="Course heading"
                                                placeholder="Enter your course heading"
                                                info="A catchy, clear headline to attract learners."
                                            />

                                            <x-client.dashboard.inputs.markdown-area
                                                id="description"
                                                label="About course"
                                                name="description"
                                                :isError="$errors->has('description')"
                                                info="Markdown is supported. Use it to describe your course in detail."
                                                :livewireComponentId="$this->getId()"
                                            />

                                            <div class="course-field mb--15 edu-bg-gray">
                                                <h6>Course Settings</h6>
                                                <div class="rbt-course-settings-content">
                                                    <div class="row g-5">
                                                        <div class="col-lg-4">
                                                            <div class="advance-tab-button advance-tab-button-1">
                                                                <ul class="rbt-default-tab-button nav nav-tabs" id="courseSetting"
                                                                    role="tablist">
                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#"
                                                                           @class(['active' => $activeCourseSettingTab === 'general'])
                                                                           wire:click.prevent="setTab('general')"
                                                                           id="general-tab"
                                                                           data-bs-toggle="tab" data-bs-target="#general"
                                                                           role="tab" aria-controls="general" aria-selected="true">
                                                                            <span>General</span>
                                                                        </a>
                                                                    </li>
                                                                    @if (auth()->user()->isInstructor())
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#"
                                                                               id="price-tab"
                                                                               @class(['active' => $activeCourseSettingTab === 'price'])
                                                                               wire:click.prevent="setTab('price')"
                                                                               data-bs-toggle="tab"
                                                                               data-bs-target="#price"
                                                                               role="tab"
                                                                               aria-controls="price" aria-selected="true">
                                                                                <span>Price</span>
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" id="batch-tab" data-bs-toggle="tab"
                                                                               @class(['active' => $activeCourseSettingTab === 'batch'])
                                                                               wire:click.prevent="setTab('batch')"
                                                                               data-bs-target="#batch" role="tab"
                                                                               aria-controls="batch" aria-selected="true">
                                                                                <span>Batch time</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#" id="information-tab" data-bs-toggle="tab"
                                                                           data-bs-target="#information" role="tab"
                                                                           @class(['active' => $activeCourseSettingTab === 'additional'])
                                                                           wire:click.prevent="setTab('additional')"
                                                                           aria-controls="information" aria-selected="true">
                                                                            <span>Additional Information</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <div class="tab-content">
                                                                <div @class([
                                                                        'tab-pane fade advance-tab-content-1',
                                                                        'active show' => $activeCourseSettingTab === 'general',
                                                                    ])
                                                                     id="general" role="tabpanel" aria-labelledby="general-tab">
                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="category"
                                                                        placeholder="Select Course Category"
                                                                        label="Course Categories"
                                                                        name="category"
                                                                        info="Select the category of your course."
                                                                        :options="App\Models\Category::all()"
                                                                    />

                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="level"
                                                                        placeholder="Select Course Level"
                                                                        label="Course Levels"
                                                                        name="level"
                                                                        info="Select the level of your course."
                                                                        :options="App\Models\Course::$LEVELS"
                                                                    />
                                                                </div>

                                                                @if (auth()->user()->isInstructor())
                                                                    <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'price',
                                                                        ])
                                                                         id="price"
                                                                         role="tabpanel" aria-labelledby="price-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                model="price"
                                                                                label="Regular Price (₫)"
                                                                                name="price"
                                                                                placeholder="₫ Regular Price"
                                                                                type="number"
                                                                                info="The Course Price Includes Your Author Fee."
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'batch',
                                                                        ])
                                                                         id="batch"
                                                                         role="tabpanel" aria-labelledby="batch-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                model="startDate"
                                                                                label="Start time"
                                                                                name="startDate"
                                                                                info="Start at 00:00"
                                                                                type="date"
                                                                            />

                                                                            <x-client.dashboard.inputs.text
                                                                                model="endDate"
                                                                                label="End time"
                                                                                name="endDate"
                                                                                info="End at 23:59"
                                                                                type="date"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'information',
                                                                        ]) id="information"
                                                                     role="tabpanel" aria-labelledby="information-tab">
                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="skills"
                                                                        label="Skills" name="skills"
                                                                        placeholder="List the key skills students will acquire from this course."/>

                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="requirements"
                                                                        label="Requirements" name="requirements"
                                                                        placeholder="Specify any prerequisites or requirements for enrolling in this course."/>

                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="targetAudiences"
                                                                        label="Who this course is for" name="requirements"
                                                                        placeholder="Describe the ideal audience for this course."/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <livewire:client.course-creation.components.course-thumbnail wire:model="thumbnail"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:client.course-creation.components.builders.course-builder wire:model="modules"/>

                            @if (auth()->user()->isOrganization())
                                <div class="accordion-item card">
                                    <h2 class="accordion-header card-header" id="accMembers">
                                        <button class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accCollapseMembers"
                                                aria-expanded="true"
                                                aria-controls="accCollapseMembers">
                                            Add members to course
                                        </button>
                                    </h2>
                                    <div wire:ignore.self
                                         id="accCollapseMembers"
                                         class="accordion-collapse collapse"
                                         aria-labelledby="accMembers"
                                         data-bs-parent="#courseCreation">
                                        <livewire:client.course-creation.components.builders.members.add-learners wire:model="membersAssigned"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt--10 row g-5">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <button type="button" wire:click="store" class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Create Course</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
