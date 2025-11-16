import "../bootstrap";

import "../../assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js";
import "../../assets/admin/libs/feather-icons/feather.min.js";
import {swalSuccess, swalError, swalConfirm} from "../../assets/admin/js/pages/sweetalerts.utils.js";
import '../../assets/admin/js/pages/datatable-init.js';
import "../../assets/admin/js/app.js";


window.swalSuccess = swalSuccess;
window.swalError = swalError;
window.swalConfirm = swalConfirm;

window.getChartColorsArray = function (id) {
    const el = document.getElementById(id);
    if (!el) return null;

    const colors = JSON.parse(el.getAttribute("data-colors"));
    return colors.map(value => {
        const color = value.replace(" ", "");
        if (color.indexOf(",") === -1) {
            return getComputedStyle(document.documentElement).getPropertyValue(color) || color;
        }
        const [base, opacity] = color.split(",");
        return `rgba(${getComputedStyle(document.documentElement).getPropertyValue(base)}, ${opacity})`;
    });
};

