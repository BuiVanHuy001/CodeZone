<div class="section-title row m-5">
    <h2>{{ $assignment->title  }}</h2>
    <div class="col-lg-8 markdown-body">
        @markdown($assignment->description)
    </div>
    <div class="col-lg-4">
        <div class="bg-color-white rbt-shadow-box">
            <h5 class="rbt-title-style-3">Assignment Submission</h5>
            <form action="#">
                <label for="images" class="drop-container rbt-custom-file-upload mt--30">
                    <span class="mb--0 h5">Drop files here</span>
                    or
                    <input type="file" id="images" required>
                </label>
            </form>

            <div class="submit-btn mt--35">
                <a class="rbt-btn btn-gradient hover-icon-reverse" href="">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Submit Assignment</span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
