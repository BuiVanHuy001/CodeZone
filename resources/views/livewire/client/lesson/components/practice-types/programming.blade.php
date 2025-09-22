<div class="section-title p-0">
    <h4>Programming Practice</h4>
    <div class="row">
        <div class="col-6">
            <h5 class="rbt-title-style-3">{{ $programmingPractice->title }}</h5>
            <div class="markdown-body mt-4 has-show-more">
                <div class="has-show-more-inner-content">
                    @markdown($programmingPractice->description)
                </div>
                <div class="rbt-show-more-btn">Show More</div>
            </div>
        </div>
        <div class="col-6">
            <x-client.dashboard.inputs.select
                label="Select programming language"
                :options="$allowedLanguages"
                model="languageSelected"
                name="languageSelected"
                info="Select programming language to start coding"
                placeholder="Select programming language"
                :default="$this->languageSelected"/>

            <div id="code-editor-{{ $programmingPractice->id }}" wire:ignore></div>

            <div class="d-flex justify-content-end">
                <button wire:click="submitCode" class="rbt-btn btn-border icon-hover btn-sm mt-3" href="#">
                    <span class="btn-text">Submit code</span>
                    <span class="btn-icon"><i class="feather-upload-cloud"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>
