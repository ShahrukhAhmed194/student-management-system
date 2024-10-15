$(document).ready(function() {
                
    $("#trial-class-datatable").DataTable({
    dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
    buttons: ["excel", "pdf", "print"],
    buttons: [
        {
            extend: "excel",
            title: "Trial Class",
            text: '<i class="ti ti-file-spreadsheet"></i> Excel',
            titleAttr: 'Trial Class Excel File',
            footer: true,
            messageTop: 'Trial Class Report',
            className: "btn-sm btn-sm btn-success",
        },
        {
            extend: "print",
            title: "Trial Class",
                text: '<i class="ti ti-printer fs-4"></i> Print',
            titleAttr: 'Trial Class Print File',
            footer: true,
            messageTop: 'Trial Class Report',
            className: "btn-sm btn-sm btn-primary",
        },
        {
            extend: "pdf",
            title: "Trial Class",
                text: '<i class="ti ti-file-text"></i> PDF',
            titleAttr: 'Trial Class PDF File',
            footer: true,
            messageTop: 'Trial Class Report',
            className: "btn-sm btn-sm btn-secondary",
            orientation: 'landscape',
            pageSize: 'LEGAL'
        },
    ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1 mb-2");});
