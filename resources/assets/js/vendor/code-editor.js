(function () {
    const safe = (fn) => (typeof fn === 'function' ? fn : () => []);
    const getLanguageExtension = (language) => {
        switch ((language || '').toLowerCase()) {
            case 'python':
                return safe(window.python)();
            case 'javascript':
            case 'js':
                return safe(window.javascript)();
            case 'java':
                return safe(window.java)();
            case 'cpp':
                return safe(window.cpp)();
            case 'php':
                return safe(window.php)();
            case 'markdown':
                return safe(window.markdown)();
            default:
                return safe(window.javascript)();
        }
    };

    function createCodeEditor(elementId, language, doc = '') {
        if (typeof window.EditorView === 'undefined') {
            console.warn('createCodeEditor: EditorView is not available.');
            return null;
        }
        const parent = document.getElementById(elementId);
        parent.innerHTML = '';

        return new window.EditorView({
            extensions: [
                window.lineNumbers && window.lineNumbers(),
                window.defaultKeymap,
                window.getLanguageExtension(language),
                window.highlightActiveLineGutter && window.highlightActiveLineGutter(),
                window.autocompletion && window.autocompletion(),
                window.highlightActiveLine && window.highlightActiveLine(),
                window.highlightSpecialChars && window.highlightSpecialChars(),
                window.EditorView.lineWrapping,
                window.oneDark,
                window.EditorView.domEventHandlers({
                    blur: (event, view) => {
                        // const content = view.state.doc.toString();

                    }
                }),
                window.EditorView.theme({
                    '&': {
                        height: '400px',
                        width: '100%',
                        border: '1px solid #ddd',
                        borderRadius: '4px',
                        padding: '10px',
                        fontSize: '13px'
                    }
                })
            ].filter(Boolean),
            parent,
            doc: doc || ''
        });
    }

    window.createCodeEditor = createCodeEditor;
    window.getLanguageExtension = getLanguageExtension;
})();
