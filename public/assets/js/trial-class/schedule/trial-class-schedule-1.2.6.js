let selectedCountry = $("#selected_country").val();
document.getElementById("country").value = selectedCountry;
$("#available_dates").hide();

function getTrialClassDateSchedules() {
    let status = $('#status').val();
    let student_name = $('#student_name').val();
    let email = $('#email').val();
    let phone = $('#phone').val();
    let age = $('#age').val();
    let gender = $('#gender').val();
   
    let data = {
        student_name : student_name,
        email : email,
        phone : phone,
        age : age,
        gender : gender,
        status : status,
    };
    
    // --------------- double admission check  ----------------
    if(status == 'Admitted'){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/trialclass-student-name-email-phone-check',
            data: data,
            beforeSend: function () {
                $(".submitBtn").prop("disabled",true);
                $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
            },
            success: function(response) {
                if(response == 'alreadyAdmitted'){
                    toastr.error('This student already admitted.');
                    $(".submitBtn").prop("disabled",true);
                }else{
                    $(".submitBtn").prop("disabled",false);
                }
                $(".loader-populate").html("");
            },
            error: function(){
                console.log('failed')
            }
        });
    }
    if(status == 'Rescheduled'){
        let age = $('#age').val();
        let teacher_id = $('#teacher_id').val();
        let country = $('#country').val();
        let data = {
            age : age,
            status : status,
            teacher_id : teacher_id ,
            country : country
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/get-trial-class-schedules',
            data: data,
            success: function(response) {
                if(response == ''){
                    $("#available_dates").empty();
                }else{
                    $("#available_dates").show();
                    var html_str = '';
                    html_str += `<span style="color:#e41111">*</span>
                        <label for="schedule" class="form-label">Trial Class Schedules</label>
                        <select id="schedule" name="schedule" class="form-select">
                            <option value="">Please Select Appropriate Date And Time </option>`;
                            $.each(response, function( index, value ) {
                                let date = new Date(value.date)
                                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                html_str +=`<option value="${value.id}">${date.toLocaleDateString("en-US", options)} &emsp;At&nbsp;  ${value.time}</option>`;
                            });
                    html_str +=`</select>`;
                    $("#available_dates").html(html_str);
                }
                
            },
            error: function(){
                console.log('failed')
            }
        });
    }
}