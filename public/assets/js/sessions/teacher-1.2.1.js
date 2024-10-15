let class_id = $('#class_id').val();
let session_id = $('#session_id').val();

function saveSession()
{
    let data = {
        class_id : class_id,
        session_id : session_id
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/start/session/info',
        data: data,
        success: function(response) {
            console.log(response);
        },
        error: function(){
            console.log('failed');
        }
    });
}

function markSessionAsCompleted(meeting_id)
{
$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/complete/session/data',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: {
            session_id: session_id,
            meeting_id: meeting_id,
        },
        beforeSend: function () {
            $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
        },
        success: function(response) {
            toastr.success('Your Session Has Ended.');
            $(".loader-populate").html("");
            location.reload(true);
        },
        error: function(){
            alert('failed');
            $(".loader-populate").html("");
        }
    });
}

function startClassStatusStore(class_session_id, teacherMeetingId){     
    
    $.ajax({
        url: "/class-session-start",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: {
            class_session_id: class_session_id,
            teacherMeetingId: teacherMeetingId,
        },
        beforeSend: function () {
            $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
        },
        success: function (r) {
            window.open(r, '_blank');
            $(".loader-populate").html("");
        },
        });
}