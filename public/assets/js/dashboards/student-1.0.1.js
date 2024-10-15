function checkIfSessionStarted()
{
    let class_id = $('#class_id').val();
    
    $.ajax({
        type: "GET",
        url: "/check-session-status/"+class_id,
        success: function(response){
            if(jQuery.isEmptyObject(response)){
                alert("Class hasn't started yet.");
            }else{
                window.location.href = "/session/student/"+class_id;
            }
        },
        error: function(response){

        }
    });
} 