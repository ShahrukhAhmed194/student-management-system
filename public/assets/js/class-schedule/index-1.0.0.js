$(document).ready(function() {
    $("#class-schedule-datatable").DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Class Schedules",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Class Schedule Excel File',
                footer: true,
                messageTop: 'Class Schedule Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Class Schedules",
                text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Class Schedule Print File',
                footer: true,
                messageTop: 'Class Schedule Report',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Class Schedules",
                text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Class Schedule PDF File',
                footer: true,
                messageTop: 'Class Schedule Report',
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        lengthMenu: [
            [10, 20, 50, 100, 150, 200, 500],
            [10, 20, 50, 100, 150, 200, "All"],
        ],
        processing: true,
        sProcessing: "<span class='fas fa-sync-alt'></span>",
        serverSide: false,
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1");
});