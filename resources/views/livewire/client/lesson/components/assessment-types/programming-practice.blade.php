<div class="section-title">
    <h4>Programming Assignment</h4>
    <div class="row">
        <div class="col-6">
            <h5 class="rbt-title-style-3">{{ $assessment->title }}</h5>
            @markdown($assessment->description)
        </div>
        <div class="col-6">
            <h5>Select programming language</h5>
            <div class="rbt-modern-select bg-transparent height-45">
                <select class="w-100">
                    @foreach($allowedProgrammingLanguages as $language)
                        <option value="{{ $language }}">{{ \App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES[$language] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="code-editor"></div>
        </div>
    </div>
</div>
