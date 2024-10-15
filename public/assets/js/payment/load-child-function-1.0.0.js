$(document).ready(function(){
    setTimeout("loadAllChild()",100);
});

function loadAllChild(){
    var fd = new FormData();

    $.ajax({
        url: "/load-allchild",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: fd,
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,

        success: function (response) {
            $("#student_id").html(response);
        },
        error: function (data){
            console.log('fail');
        }
    });
}