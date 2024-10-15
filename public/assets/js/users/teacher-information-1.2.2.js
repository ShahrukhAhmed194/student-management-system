$(document).ready(function(){
 showDiv();
});

function showDiv() {
    let current_page_url = window.location.href;
    let position = current_page_url.search("create");
    let user_type = $('#user_type').val();

    if(user_type == 'Teacher'){
        $('#zoom_link_div').show();
        $('#class_login_details_div').show();
        $('#zoom_topic_div').show();
        $('#zoom_meeting_id_div').show();
        $('#zoom_password_div').show();
        $('#track_div').show();
        $('#course_div').show();
        $('.common_trackids_div').html("");
    }else{
        $('#zoom_link_div').hide();
        $('#class_login_details_div').hide();
        $('#zoom_topic_div').hide();
        $('#zoom_meeting_id_div').hide();
        $('#zoom_password_div').hide();
        $('#track_div').hide();
        $('#course_div').hide();
        $('.common_trackids_div').html("<input type='hidden' id='common_track_ids' name='track_ids[]'>");
        if(position > 0){
            $('#value_a').val('');
            $('#class_login_details').val('');
            $('#zoom_topic').val('');
            $('#zoom_meeting_id').val('');
            $('#zoom_password').val('');
        }
    }
}

$('#active').click(function(){
    $('#status').val(1);
});

$('#inactive').click(function(){
    $('#status').val(0);
});

function courseWisetrack(){
    var course_id = $("#course_id").val();
    $.ajax({
        url: "/course-wise-track",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: {
          course_id: course_id
        },
        beforeSend: function () {
            $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
        },
        success: function (r) {
            $("#track_ids").html(r);       
            $(".loader-populate").html("");
        },
        });
}