import './bootstrap';
import '../assets/js/vendor/modernizr.min.js';
import '../assets/js/vendor/jquery.js';
import '../assets/js/vendor/bootstrap.min.js';
import '../assets/js/vendor/sal.js';
import '../assets/js/vendor/js.cookie.js';
import '../assets/js/vendor/jquery.style.switcher.js';
import '../assets/js/vendor/swiper.js';
import '../assets/js/vendor/jquery-appear.js';
import '../assets/js/vendor/odometer.js';
import '../assets/js/vendor/backtotop.js';
import '../assets/js/vendor/text-type.js';
import '../assets/js/vendor/jquery-one-page-nav.js';
import '../assets/js/vendor/bootstrap-select.min.js';
import '../assets/js/vendor/jquery-ui.js';
import '../assets/js/vendor/magnify-popup.min.js';
import '../assets/js/vendor/paralax-scroll.js';
import '../assets/js/vendor/paralax.min.js';
import '../assets/js/vendor/countdown.js';
import '../assets/js/vendor/plyr.js';
import '../assets/js/vendor/jodit.min.js';
import '../assets/js/vendor/Sortable.min.js';
import '../assets/js/main.js';

import {
    EditorView,
    highlightActiveLine,
    highlightActiveLineGutter,
    highlightSpecialChars,
    keymap,
    lineNumbers,
} from "@codemirror/view"
import {defaultKeymap, history, historyKeymap} from "@codemirror/commands"
import {python} from "@codemirror/lang-python";
import {oneDark} from "@codemirror/theme-one-dark";
import {foldGutter} from "@codemirror/language";
import {autocompletion} from "@codemirror/autocomplete";
import {markdown} from "@codemirror/lang-markdown";

let codeEditor = new EditorView({
    extensions: [
        lineNumbers(),
        foldGutter(),
        autocompletion(),
        history(),
        python(),
        highlightActiveLine(),
        highlightActiveLineGutter(),
        keymap.of([...defaultKeymap, ...historyKeymap]),
        EditorView.lineWrapping,
        EditorView.theme({
            "&": {
                height: "300px",
                width: "100%",
                border: "1px solid #ddd",
                borderRadius: "4px",
                padding: "10px",
                fontSize: "13px",
            },
            ".cm-content": {
                caretColor: "#fff",
            },
        }),

        oneDark,
    ],
    doc: `# Viết code của bạn vào đây
def sum_array(numbers):
    # TODO: Viết logic của bạn ở đây
    return 0

# Dữ liệu đầu vào đ�� kiểm thử
input_data = [1, 2, 3, 4, 5]

# Gọi hàm của bạn và in kết quả
print(sum_array(input_data))`,
    parent: document.getElementById('code-editor')
});

const courseDescriptionInput = document.querySelector('#description_input');

let descriptionEditor = new EditorView(
    {
        extensions: [
            lineNumbers(),
            markdown(),
            highlightSpecialChars(),
            EditorView.lineWrapping,
            EditorView.updateListener.of(update => {
                if (update.docChanged) {
                    courseDescriptionInput.value = update.state.doc.toString();
                    courseDescriptionInput.dispatchEvent(new Event('input'));
                }
            }),
            EditorView.theme({
                "&": {
                    height: "200px",
                    width: "100%",
                    border: "1px solid #ddd",
                    borderRadius: "4px",
                    padding: "10px",
                    fontSize: "13px",
                },
                ".cm-content": {
                    caretColor: "#000",
                },
            }),
        ],
        parent: document.getElementById('description'),
    }
);
