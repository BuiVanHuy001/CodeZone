import "../bootstrap";

import "../../assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js";
import "../../assets/admin/libs/feather-icons/feather.min.js";
import "../../assets/admin/js/pages/plugins/lord-icon-2.1.0.js";

import "../../assets/admin/js/app.js";

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

