$(document).ready(function() {
                
    $("#attendance-datatable").DataTable({
    dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
    buttons: ["excel", "pdf", "print"],
    buttons: [
        {
            extend: "excel",
            title: "Student Attendance",
            text: '<i class="ti ti-file-spreadsheet"></i> Excel',
            titleAttr: 'Student Attendance Excel File',
            footer: true,
            messageTop: 'Student Attendance Report',
            className: "btn-sm btn-sm btn-success",
        },
        {
            extend: "print",
            title: "Student Attendance",
                text: '<i class="ti ti-printer fs-4"></i> Print',
            titleAttr: 'Student Attendance Print File',
            footer: true,
            messageTop: 'Student Attendance Report',
            className: "btn-sm btn-sm btn-primary",
        },
        {
            extend: "pdf",
            title: "Student Attendance",
                text: '<i class="ti ti-file-text"></i> PDF',
            titleAttr: 'Student Attendance PDF File',
            footer: true,
            messageTop: 'Student Attendance Report',
            className: "btn-sm btn-sm btn-secondary",
            orientation: 'landscape',
            pageSize: 'LEGAL'
        },
    ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1 mb-2");});
