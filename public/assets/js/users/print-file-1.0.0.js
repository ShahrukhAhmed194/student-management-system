$(document).ready(function() {
    $('#all-users-datatable').DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "All Users",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'All Users Excel File',
                footer: true,
                messageTop: 'All Users Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "All Users",
                text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'All Users Print File',
                footer: true,
                messageTop: 'All Users Report',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "All Users",
                text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'All Users PDF File',
                footer: true,
                messageTop: 'All Users Report',
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn mr-1");
});