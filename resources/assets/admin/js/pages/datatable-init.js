window.initializedTables = window.initializedTables || {};

function stripDtButtonClasses(tableInstance) {
    if (!tableInstance) return;
    const $container = tableInstance.buttons().container();
    $container.find('.dt-button').each(function () {
        const $btn = $(this);
        if ($btn.hasClass('btn')) {
            $btn.removeClass('dt-button');
        }
    });
}

function initTable(selector, opts = {}) {
    if (typeof $ === 'undefined' || typeof $.fn === 'undefined') {
        console.warn('jQuery not loaded yet, skipping DataTable initialization');
        return null;
    }

    const el = $(selector);
    if (!el.length) return null;

    if (typeof $.fn.DataTable === 'undefined') {
        console.warn('DataTables plugin not loaded yet');
        return null;
    }

    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
    }
    const domLayoutWithButtons = '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6 d-flex align-items-center"li><"col-sm-12 col-md-6"p>>';
    const defaultOptions = {
        dom: domLayoutWithButtons,
        fixedHeader: true,
        scrollX: true,
        scrollY: 500,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        pageLength: 10,
        searching: true,
        order: [],
    };

    const config = Object.assign({}, defaultOptions, opts);

    const table = el.DataTable(config);
    window.initializedTables[selector] = table;
    stripDtButtonClasses(table);
    return table;
}

function initializeDataTables(tableDefinitions) {
    if (!tableDefinitions || !Array.isArray(tableDefinitions)) {
        console.warn('No table definitions provided.');
        return;
    }
    tableDefinitions.forEach(({selector, opts}) => initTable(selector, opts));
}

window.AppDataTableHelper = {
    initializeDataTables: initializeDataTables,
};

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
