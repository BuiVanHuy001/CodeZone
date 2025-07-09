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
import 'quill/dist/quill.snow.css';
import Quill from 'quill';
import '../assets/js/main.js';

const toolbarOptions = [
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    [{'font': []}],
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    ['link'],
    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
    [{'indent': '-1'}, {'indent': '+1'}],
    [{'align': []}],
];

function initQuill() {
    const el = document.querySelector('#description');
    if (el && !el.classList.contains('ql-container')) {
        let quill = new Quill(el, {
            theme: 'snow',
            modules: {toolbar: toolbarOptions}
        });

        quill.on('text-change', function () {
            const input = document.querySelector('#description_input');
            input.value = quill.getText();
            input.dispatchEvent(new Event('input'));
        });
    }
}

initQuill();
