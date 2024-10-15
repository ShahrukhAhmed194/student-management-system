$('.loader-div').hide();
function showRecordings()
{
    let data = {
        date : $('#meetingDate').val()
    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/get-class-recordings',
        data: data,
        beforeSend:function(){
            $(".loader-div").show();
            setTimeout(function() {
                $(".loader-div").hide();
            }, 400);
        },
        success: function(response) {
            var html_str = '';
            html_str += `<option value="">Please Select Recording </option>`;
                    $.each(response, function( index, value ) {
                        let start = convertTime(value.recording_start.split(' ')[1]);
                        let end = convertTime(value.recording_end.split(' ')[1]);
                        html_str +=`<option value="${value.id}">Teacher : ${value.meeting_id};&nbsp; Start : ${start};&nbsp; End : ${end}</option>`;
                    });
            $("#classRecording").html(html_str);
        },
        error: function(){
            console.log('failed')
        }
    });
}
function convertTime(time) 
{
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
    if (time.length > 1) { 
        time = time.slice (1);  
        time[5] = +time[0] < 12 ? 'AM' : 'PM'; 
        time[0] = +time[0] % 12 || 12; 
    }
    return time.join (''); 
}