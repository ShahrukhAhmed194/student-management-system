$(document).ready(function() {
    function showParamsInFilters()
    {
        let urlParams = new URLSearchParams(window.location.search);
        let student_name = urlParams.get('student_name');
        let teacher_id = urlParams.get('teacher_id');
        let student_id = urlParams.get('student_id');
        let date = urlParams.get('date');
        let time = urlParams.get('time');
    
        $('#student_name').val(student_name);
        $('#teacher_id').val(teacher_id);
        $('#student_id').val(student_id);
        $('#date').val(date);
        $('#time').val(time);
    }

    window.onload = function() {
        showParamsInFilters();
    };

    $("#classdetails-datatable").DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Class Details",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Class Details Excel File',
                footer: true,
                messageTop: 'Class Details Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Class Details",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Class Details Print File',
                footer: true,
                messageTop: 'Class Details Report',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Class Details",
                    text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Class Details PDF File',
                footer: true,
                messageTop: 'Class Details Report',
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

    $('.callButton').on('click', function() {
        var classDetail = $(this).closest('.classDetails');
        var student_id = classDetail.find('input[name="student_id"]').val();
        var user_id = classDetail.find('input[name="user_id"]').val();
        var phone = classDetail.find('input[name="phone"]').val();
        var btn = $(this);

        $.ajax({
            url: 'save-student-call-history',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {
                student_id: student_id,
                user_id: user_id,
                phone: phone,
            },
            beforeSend:function(){
                btn.html('<i class="ti ti-phone-outgoing"></i>&nbsp;Calling...');
;            },
            success: function(response) {
                btn.html('<i class="ti ti-phone-outgoing"></i>&nbsp;Call');
            },
            error: function(xhr, status, error) {
                btn.html('<i class="ti ti-phone-outgoing"></i>&nbsp;Call');
            }
        });
    });
});