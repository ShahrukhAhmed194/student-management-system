$(document).ready(function() {
    $('#trial-class-rpt-datatable').DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Trial Class Admission Report",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Trial Class Admission Report Excel File',
                footer: true,
                messageTop: 'Trial Class Admission Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Trial Class Admission Report",
                text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Trial Class Admission Report Excel File',
                footer: true,
                messageTop: 'Trial Class Admission Report ',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Trial Class Admission Report",
                text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Trial Class Admission PDF File',
                footer: true,
                messageTop: 'Trial Class Admission Report',
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1 mb-2 ");
});