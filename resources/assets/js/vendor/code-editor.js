import {EditorView, lineNumbers, highlightActiveLine, keymap} from "@codemirror/view";
import {defaultKeymap, history, historyKeymap, indentWithTab} from "@codemirror/commands";
import {python} from "@codemirror/lang-python";
import {javascript} from "@codemirror/lang-javascript";
import {java} from "@codemirror/lang-java";
import {cpp} from "@codemirror/lang-cpp";
import {php} from "@codemirror/lang-php";
import {markdown} from "@codemirror/lang-markdown";
import {oneDark} from "@codemirror/theme-one-dark";
import {foldGutter, bracketMatching} from "@codemirror/language";
import {autocompletion, closeBrackets, closeBracketsKeymap} from "@codemirror/autocomplete";
import {highlightSelectionMatches} from "@codemirror/search";

const getLanguageExtension = (lang = '') => {
    switch (lang.toLowerCase()) {
        case "python":
            return python();
        case "javascript":
        case "js":
            return javascript();
        case "java":
            return java();
        case "cpp":
            return cpp();
        case "php":
            return php();
        case "markdown":
            return markdown();
        default:
            return javascript();
    }
};

export function createCodeEditor(elementId, language, doc = "", darkMode = true, livewireComponentId, livewireProperty) {
    const parent = document.getElementById(elementId);
    if (!parent) return null;

    parent.innerHTML = "";

    return new EditorView({
        extensions: [
            lineNumbers(),
            getLanguageExtension(language),
            history(),
            foldGutter(),
            bracketMatching(),
            closeBrackets(),
            highlightSelectionMatches(),
            autocompletion({activateOnTyping: true}),
            keymap.of([...defaultKeymap, ...historyKeymap, ...closeBracketsKeymap, indentWithTab]),
            highlightActiveLine(),
            darkMode ? oneDark : [],
            EditorView.lineWrapping,
            EditorView.domEventHandlers({
                blur: (event, view) => {
                    if (livewireComponentId && livewireProperty) {
                        Livewire.find(livewireComponentId).set(livewireProperty, view.state.doc.toString());
                    } else {
                        Livewire.dispatch('code-editor-blur', [view.state.doc.toString()]);
                    }
                }
            }),
            EditorView.theme({
                "&": {
                    height: "400px",
                    width: "100%",
                    border: "1px solid #ddd",
                    borderRadius: "4px",
                    padding: "10px",
                    fontSize: "13px"
                }
            })
        ],
        parent,
        doc: doc || ""
    });
}

