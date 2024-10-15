$(document).ready(function() {
    $('#attendance-rpt-datatable').DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
    buttons: ["excel", "pdf", "print"],
    buttons: [
        {
            extend: "excel",
            title: "Trial-class-Schedule",
            text: '<i class="ti ti-file-spreadsheet"></i> Excel',
            titleAttr: 'Trial class schedule Excel File',
            footer: true,
            messageTop: 'Trial class Schedule Report',
            className: "btn-sm btn-sm btn-success",
        },
        {
            extend: "print",
            title: "Trial class Schedule",
            text: '<i class="ti ti-printer fs-4"></i> Print',
            titleAttr: 'Trial class Schedule Excel File',
            footer: true,
            messageTop: 'Trial class Schedule Report',
            className: "btn-sm btn-sm btn-primary",
        },
        {
            extend: "pdf",
            title: "Trial class Schedule",
            text: '<i class="ti ti-file-text"></i> PDF',
            titleAttr: 'Trial class Schedule PDF File',
            footer: true,
            messageTop: 'Trial class Schedule Report',
            className: "btn-sm btn-sm btn-secondary",
            orientation: 'landscape',
            pageSize: 'LEGAL'
        },
    ],
});
$(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel").addClass("btn btn-primary mr-1");

});

function attendance_details(){
    let fd ={
     id : $('#select-student').val(),
     class_id : $('#class_id').val(),
     from_date : $('#from_date').val(),
     to_date : $('#to_date').val()
    };

    $.ajax({
        url  : "/attendance/childs",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: fd,
        beforeSend: function(){
            $('.preloader').show();
        },
        success: function (response) {
            $('.preloader').hide();
            $('tbody').empty();
            if(response.length === 0){
                $('tbody').append('<tr>');
                $('tbody').append('<td colspan="5" class="text-center">Record not found!</td>');
                $('tbody').append('</tr>');
            }else{
                $.each(response, function( index, value ) {
                    var row_class = (index%2==0 ? 'even' : 'odd'); 
                    var status = (value.status == 1 ? 'Present' : 'Absent');
                    var comments = (value.comments == null ? ' ' : value.comments);
                    var no = index+1;
                    
                    $('tbody').append('<tr class='+row_class+'><td>'+no+'</td><td>'+value.name+'</td><td>'+value.date+'</td><td>'+status+'</td><td>'+comments+'</td></tr>');
                });
            }
        },
        error: function (data){
            console.log('fail');
        }
    });
}