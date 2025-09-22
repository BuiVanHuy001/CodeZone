<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Assignment"
    name="assignment">
    <div x-show="showDetail">
        <x-client.dashboard.inputs.text
            model="assignment.title"
            name="assignment.title"
            label="Assignment Title"
            placeholder="Enter assignment title"
            info="Provide a clear, descriptive title for this assignment."
        />

        <x-client.dashboard.inputs.markdown-area
            id="assignment-description{{ !empty($unique) ? '-' . $unique : '' }}"
            label="Assignment Description"
            info="Markdown is supported."
            name="assignment.description"
            placeholder="Enter assignment description"
            :isError="$errors->has('assignment.description')"
        />

        <div class="d-flex pt--30 justify-content-between">
            <div class="content">
                <button type="button"
                        class="awe-btn bg-danger"
                        wire:click="remove">
                    Cancel
                </button>
            </div>

            <div class="content">
                <button
                    type="button"
                    class="awe-btn"
                    wire:click="save"
                    @disabled($errors->has('assignment.*'))>
                    <span>Save</span>
                </button>
            </div>
        </div>

    </div>
</x-client.dashboard.course-creation.builders.assessment-types.base>
@script
<script>
    createCodeEditor(
        'assignment-description{{ !empty($unique) ? '-' . $unique : '' }}-editor',
        'markdown',
        @json($assignment['description'] ?? '', JSON_THROW_ON_ERROR),
        false,
        @json($this->getId(), JSON_THROW_ON_ERROR),
        'assignment.description'
    );
</script>
@endscript
