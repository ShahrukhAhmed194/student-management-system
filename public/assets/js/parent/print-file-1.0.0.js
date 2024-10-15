$(document).ready(function() {
    
    $('#parents-datatable').DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Parents",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Parents Excel File',
                footer: true,
                messageTop: 'Parents Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Parents",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Parents Print File',
                footer: true,
                messageTop: 'Parents Report',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Parents",
                    text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Parents PDF File',
                footer: true,
                messageTop: 'Parents Report',
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1");
});