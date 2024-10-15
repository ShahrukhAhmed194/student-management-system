$(document).ready(function() {
    $('#sales-rpt-datatable').DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Sales Report",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Sales Report Excel File',
                footer: true,
                messageTop: 'Total Sales Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Sales Report",
                text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Sales Report Excel File',
                footer: true,
                messageTop: 'Total Sales Report ',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Sales Report",
                text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Sales Report PDF File',
                footer: true,
                messageTop: 'Total Sales Report',
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1 mb-2 ");
});

function addParamsToUrl(key, value)
{
    const searchParams = new URLSearchParams(window.location.search);
    searchParams.set(key, value);
    const newRelativePathQuery = window.location.pathname + "?" + searchParams.toString();
    history.pushState(null, "", newRelativePathQuery);
}

function showParamsInURL()
{
    let urlParams = new URLSearchParams(window.location.search);
    let email = urlParams.get('start_date');
    let date = urlParams.get('end_date');

    $('#start_date').val(email);
    $('#end_date').val(date);
}
