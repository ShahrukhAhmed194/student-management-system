$(".loader-div").hide();
window.onload = function() {
    showParamsInFilters();
};

function validateSessionInfo( recordingId, key, videoLink)
{
    if(!$('#is_trial_'+key).is(":checked")){
        if($('#session_id_'+key).val() == null){
            $('#session_info_error_'+key).removeClass('d-none');
            return;
        }
    }
    
    let data_list = {
        recording_id : recordingId,
        is_trial : $('#is_trial_'+key).is(":checked"),
        vimeo_embed_html : videoLink,
        session_id : $('#session_id_'+key).val()
    };
    
    $.ajax({
        url: "/update-live-video-single",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: data_list,
        beforeSend:function(){
            $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
        },
        success: function (response) {
            $("#is_trial_"+key).prop("checked", false);
            $('#row_'+key).hide('slow');
            $(".loader-populate").html("");
        },
        error: function (data){
            $(".loader-populate").html("");
            console.log('fail');
        }
    });
}

function addParamsToUrl(key, value)
{
    const searchParams = new URLSearchParams(window.location.search);
    searchParams.set(key, value);
    const newRelativePathQuery = window.location.pathname + "?" + searchParams.toString();
    history.pushState(null, "", newRelativePathQuery);
}

function showParamsInFilters()
{
    let urlParams = new URLSearchParams(window.location.search);
    let email = urlParams.get('email');
    let date = urlParams.get('date');

    $('#teacher_email').val(email);
    $('#meeting_date').val(date);
}