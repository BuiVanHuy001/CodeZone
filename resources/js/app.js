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
import Plyr from 'plyr';
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
import {javascript} from "@codemirror/lang-javascript";
import {java} from "@codemirror/lang-java";
import {cpp} from "@codemirror/lang-cpp";
import {php} from "@codemirror/lang-php";
import {oneDark} from "@codemirror/theme-one-dark";
import {foldGutter} from "@codemirror/language";
import {autocompletion} from "@codemirror/autocomplete";
import {markdown} from "@codemirror/lang-markdown";

window.Plyr = Plyr;

window.EditorView = EditorView;
window.highlightActiveLine = highlightActiveLine;
window.highlightActiveLineGutter = highlightActiveLineGutter;
window.highlightSpecialChars = highlightSpecialChars;
window.keymap = keymap;
window.lineNumbers = lineNumbers;
window.defaultKeymap = defaultKeymap;
window.CodeMirrorHistory = history;
window.historyKeymap = historyKeymap;
window.python = python;
window.javascript = javascript;
window.java = java;
window.cpp = cpp;
window.php = php;
window.oneDark = oneDark;
window.foldGutter = foldGutter;
window.autocompletion = autocompletion;
window.markdown = markdown;

import '../assets/js/main.js';
