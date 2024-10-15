function addParamsToUrl(key, value)
{
    const searchParams = new URLSearchParams(window.location.search);
    searchParams.set(key, value);
    const newRelativePathQuery = window.location.pathname + "?" + searchParams.toString();
    history.pushState(null, "", newRelativePathQuery);
}

function showParamsInURL()
{
    let urlParams = new URLSearchParams(window.location.search);
    let start_date = urlParams.get('start_date');
    let end_date = urlParams.get('end_date');
    let is_due = urlParams.get('is_due');
    let email = urlParams.get('email');
    let phone = urlParams.get('phone');
    let due_installments = urlParams.get('due_installments');

    $('#start_date').val(start_date);
    $('#end_date').val(end_date);
    $('#due_installments').val(due_installments);
    $('#email').val(email);
    $('#phone').val(phone);
    if(is_due == 1){
        $('#is_due').prop('checked', true);
    }
}

function showIsDueInUrl()
{
    let is_due_hidden = $('#is_due_hidden').val();
    if($("#is_due").is(':checked')){
        addParamsToUrl('is_due', is_due_hidden);
    }else{
        addParamsToUrl('is_due', '');
    }
    
}

window.onload = function()
{
    showParamsInURL();
}

function saveStudentCallHistoryData(sl)
{
    var fd = new FormData();
    var user_id = $("#user_id").attr('data-user-id');
    var student_id = $("#student-id-"+sl).attr('data-student-id');
    var phone = $("#phone-"+sl).attr('data-phone');

    fd.append("user_id", user_id);
    fd.append("student_id", student_id);
    fd.append("phone", phone);

    $.ajax({
        url: "save-student-call-history",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: fd,
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        beforeSend:function(){
            var loaderImg = "/assets/img/ajax-loader.gif";
            $(".callerIcon-"+sl).html('<img src="'+ loaderImg +'" /> &nbsp; Calling ...');  
        },
        success: function (response) {
            if(response == 1){
                $(".callerIcon-"+sl).html("<i class='ti ti-phone'> </i>&nbsp;Call")
            }
        },
        error: function (data){
            console.log('fail');
        }
    });
}