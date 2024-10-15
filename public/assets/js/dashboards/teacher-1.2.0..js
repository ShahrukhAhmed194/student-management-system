window.onload = function() {
    $("#note-business").click();
    $(document).ready(function(){
        $("#note-business").click(); 
    });
};

function getRegularClassStudents(scheduleId, classId){            
    $.ajax({
        type : "GET",
        url  : "student-per-class/" + classId,
        success: function (response) {  
            $('#students_' + scheduleId).empty().append('');
            $.each(response, function(index, value) {
                $('#students_' + scheduleId).append(value.name);
                $('#students_' + scheduleId).append(',<br> ');
            });
        },
        error: function (data){
            console.log('fail');
        }
    });
}

function getTodaysClassStudents(scheduleId, classId){            
    $.ajax({
        type : "GET",
        url  : "student-per-class/" + classId,
        success: function (response) {  
            $('#today_students_' + scheduleId).empty().append('');
            $.each(response, function(index, value) {
                $('#today_students_' + scheduleId).append(value.name);
                $('#today_students_' + scheduleId).append(', ');
            });
        },
        error: function (data){
            console.log('fail');
        }
    });
}