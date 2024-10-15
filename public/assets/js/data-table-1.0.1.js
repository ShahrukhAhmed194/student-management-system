function getPDFCVSExcelDataReport(id, fileName)
{
    $('#'+id).DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: fileName,
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: fileName+' Excel File',
                footer: true,
                messageTop: fileName,
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: fileName,
                text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: fileName+' Print File',
                footer: true,
                messageTop: fileName,
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: fileName,
                text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: fileName+' PDF File',
                footer: true,
                messageTop: fileName,
                className: "btn-sm btn-sm btn-secondary",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
    });
    $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1 mb-2 ");
}