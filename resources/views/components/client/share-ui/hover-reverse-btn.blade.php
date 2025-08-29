<button @click="testCaseForm = false; addTestCaseButton = true;"
        type="{{ $type }}"
        class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2 mt-3 col-4">
    <span class="icon-reverse-wrapper">
        <span class="btn-text">{{ $label }}</span>
        <span class="btn-icon"><i class="feather-{{ $icon }}"></i></span>
        <span class="btn-icon"><i class="feather-{{ $icon }}"></i></span>
    </span>
</button>
