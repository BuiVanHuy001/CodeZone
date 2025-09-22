<div class="section-title content">
    <h4>Programming Assignment</h4>
    <div class="row">
        <div class="col-6">
            <h5 class="rbt-title-style-3">{{ $problem->title }}</h5>
            <div class="markdown-body mt-4 has-show-more">
                <div class="has-show-more-inner-content">
                    @markdown($problem->description)
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
                :default="$this->languageSelected"
            />

            <div id="code-editor-{{ $problem->id }}" wire:ignore></div>

            <div class="d-flex justify-content-end">
                <button wire:click="submitCode" class="rbt-btn btn-border icon-hover btn-sm mt-3" href="#">
                    <span class="btn-text">Submit code</span>
                    <span class="btn-icon"><i class="feather-upload-cloud"></i></span>
                </button>
            </div>
        </div>
    </div>

    @if($executionErrors)
        <div class="result_container" x-data>
            <div class="terminal_toolbar">
                <div class="butt">
                    <button class="btn btn-color" @click.stop="$root.remove()"></button>
                </div>
                <p class="user">Your execution result: ~</p>
                <button class="add_tab">+</button>
            </div>
            <div class="terminal_body">
                <div class="terminal_promt">
                    <span class="terminal_user">{{ $executionErrors }}</span>
                </div>
            </div>
        </div>
    @endif
</div>

@assets
<style>
    .result_container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 700px;
        height: 500px;
        background: #1e1e1e;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .result_container .terminal_toolbar {
        display: flex;
        height: 35px;
        align-items: center;
        padding: 0 15px;
        background: #2d2d2d;
        justify-content: space-between;
    }

    .result_container .butt {
        display: flex;
        align-items: center;
    }

    .result_container .btn {
        height: 13px;
        width: 13px;
        border-radius: 50%;
        margin-right: 8px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .result_container .btn:hover {
        transform: scale(1.1);
    }

    .result_container .btn-color:nth-child(1) {
        background: #ff5f56;
    }

    .result_container .btn-color:nth-child(2) {
        background: #ffbd2e;
    }

    .result_container .btn-color:nth-child(3) {
        background: #27c93f;
    }

    .result_container .add_tab {
        border: none;
        color: #ffffff;
        background: #3a3a3a;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .result_container .add_tab:hover {
        background: #4a4a4a;
    }

    .result_container .user {
        margin: 0;
        color: #ffffff;
        font-size: 14px;
        font-weight: bold;
    }

    .result_container .terminal_body {
        background: #1e1e1e;
        height: calc(100% - 35px);
        padding: 15px;
        font-family: "Consolas", monospace;
        font-size: 14px;
        line-height: 1.5;
        overflow-y: auto;
    }

    .result_container .terminal_promt {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .result_container .terminal_promt span {
        margin-right: 5px;
    }

    .result_container .terminal_user {
        color: #00ff9c;
    }
</style>
@endassets
