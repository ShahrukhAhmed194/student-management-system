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

function markSessionAsCompleted()
{
$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/complete/session/data/'+session_id,
        success: function(response) {
            toastr.success('Your Session Has Ended.');
        },
        error: function(){
            alert('failed');
        }
    });
}