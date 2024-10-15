$(".loader-div").hide();
function attendance_details(){
    let id = $('#select-student').val();
    $.ajax({
        type : "GET",
        url  : "get-childs-attendance-history/"+id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData: false,
        contentType: false,
        beforeSend:function(){
            $(".loader-div").show();
            setTimeout(function() {
                $(".loader-div").hide();
            }, 400);
        },
        success: function (response) {
            $('tbody').empty();
            $.each(response, function( index, value ) {
                $('tbody').append('<tr>');
                $('tbody').append('<td>'+value.date+'</td>');
                if(value.status == 1){
                    $('tbody').append('<td>Yes</td>');   
                }else{
                    $('tbody').append('<td>No</td>');   
                }
                $('tbody').append('<td>'+value.comments+'</td>');   
                $('tbody').append('</tr>');   
            });
        },
        error: function (data){
            console.log('fail');
        },
        complete: function(){
            $(".loader-div").show();
            setTimeout(function() {
                $(".loader-div").hide();
            }, 400);
        }
    });
}