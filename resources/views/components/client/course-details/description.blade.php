@if($description)
    <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30 has-show-more" id="details">
        <div class="row g-5 has-show-more-inner-content">
            <div class="col-12">
                <div class="section-title">
                    <h4 class="rbt-title-style-3">Description</h4>
                </div>
                <div class="markdown-body">
                    @markdown($description)
                </div>

            </div>
        </div>
        <div class="rbt-show-more-btn">Show all</div>
    </div>
@endif
