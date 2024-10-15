$('#languages').hide();
$('#reg_progress').hide();
$('#indian_time').hide();
$('#uk_time').hide();

function getTrialClassDates() 
{
    let country =  $('#country').val();
    let age = $('#age').val();
    if(country == 'India'){
        $('#languages').show();
        $('#bangladeshi_time').hide();
        $('#indian_time').show();
        $('#uk_time').hide();
    }else if(country == 'United Kingdom'){
        $('#languages').hide();
        $('#bangladeshi_time').hide();
        $('#indian_time').hide();
        $('#uk_time').show();
    }else{
        $('#languages').hide();
        $('#bangladeshi_time').show();
        $('#indian_time').hide();
        $('#uk_time').hide();
    }
    if(country.length > 0 && age.length > 0){
        $.ajax({
            type: 'POST',
            url: '/getdate',
            data: {
                "age": age,
                "country": country
            },
            success: function(data) {
                var html_str_date = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        html_str_date += `<div class="form-check radioDiv">
                                            <input class="form-check-input" type="radio" onclick="getTrialTime()" name="class_date" value="${data[i].date}" id="flexRadioDefault${i}" required="">
                                            <label class="form-check-label radioStyle" role='button' for="flexRadioDefault${i}">                                            
                                            ${ new Date(data[i].date).toLocaleDateString('en-us', { weekday:"short", month:"short", day:"numeric" }) } <br>
                                            </label>
                                        </div>`;
                    }
                } else {
                    if($('#country').val() == 'United Kingdom'){
                        html_str_date += `<div class="form-check radioDiv">
                                            <p>Sorry,&#128532; No Dates Are Available At This Moment.</p>
                                        </div>`;
                    }else{
                        html_str_date += `<div class="form-check radioDiv">
                                            <p>No Date Is Available,&#128532; Please Contact Us: +880 1301528308 , +880 1301507842.&#128222;</p>
                                        </div>`;
                    }
                }
                $("#available-dates").html(html_str_date);
            }
        });
        emptyTime()
    }
}

function getTrialTime() 
{
    $.ajax({
        type: 'POST',
        url: '/gettime',
        data: {
            "date": document.querySelector('input[name="class_date"]:checked').value, //document.getElementById('trial_date').value
            "age": document.getElementById('age').value,
            "country": document.getElementById('country').value
        },
        success: function(data) {
            var html_str = '';
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    html_str += `<div class="form-check radioDiv">
                                    <input class="form-check-input" type="radio" name="trial_class_id" value="${data[i].id}" id="trialclasstime${i}" required="">
                                    <label class="form-check-label radioStyle" role='button' for="trialclasstime${i}">
                                        ${convertTime(data[i].time) } <br>
                                    </label>
                                </div>`;
                }
            } else {
                html_str += `<div class="form-check radioDiv">
                                <p>No Date Available, Please Contact Us: +880 1897-717780; +880 1897-717781.</p>
                            </div>`;
            }
            $("#available-times").html(html_str);
        }
    });
}

function emptyTime() 
{
    var html_str = '';
    html_str += `<div class="form-check radioDiv">
                    <p>Please select date to view times.</p>
                </div>`;

    $("#available-times").html(html_str);
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

function disableRegistrationButton() 
{
    let alert_value = ['Guardian Name', 'Phone Number', 'Email','Occupation', 'Country', 'Hear From Us', 'Computer/Laptop', 'Student Name', 'age','School', 'Gender'];
    let checker = [];
    let counter = 0;            
    checker[0] =  $('#gurdian_name').val();
    checker[1] =  $('#phone').val();
    checker[2] =  $('#email').val();
    checker[3] =  $('#occupation').val();
    checker[4] =  $('#country').val();
    checker[5] =  $('#hear_from').val();
    checker[6] =  $('#hasDevice1').val();
    checker[7] =  $('#student_name').val();
    checker[8] =  $('#age').val();
    checker[9] =  $('#school').val();
    checker[10] = $("input[type='radio'][name='gender']:checked").val();
    
    for(let index = 0; index < checker.length; index++){
        if(checker[index] == ''){
            console.log(checker[index]+' Field Incomplete.');
            counter++;
            break;
        }
    }

    if(counter == 0){
        // ---------------------
        let phone = $('#phone').val();
        let email = $('#email').val();
        let data = {
            email : email,
            phone : phone,
        };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/trialclass-student-email-phone-check-morethantwotimes',
                data: data,
                beforeSend: function () {
                    $("#submit_btn").prop("disabled",true);
                    $('#reg_progress').show();
                    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
                },
                success: function(response) {
                    $(".loader-populate").html("");
                    if(response == 'alreadyEmailAdmitted'){
                        toastr.error('This email has already been registered.');
                        $("#submit_btn").prop("disabled",false);
                        $('#reg_progress').hide();
                        return false;
                    }
                    if(response == 'alreadyPhoneAdmitted'){
                        toastr.error('This phone number has already been registered.');
                        $("#submit_btn").prop("disabled",false);
                        $('#reg_progress').hide();
                        return false;
                    }
                    $('#online-application-form').submit();
                },
                error: function(){
                    console.log('failed')
                }
            });
        // ---------------------
    }
}

function checkCountryOfUserAndRedirect()
{
    $.ajax({
        type: "GET",
        url: "https://extreme-ip-lookup.com/json/?key=95ymJDQRoHLKFirzaOpI",
        success: function(response, status)
        {
            if(response.country == 'United Kingdom'){

                window.open('https://dreamersacademy.co.uk/', '_blank');
            }else if (response.country === 'India') {

                window.open('https://dreamersacademy.xyz/', '_blank');
            }else{

                window.open('https://dreamersacademy.com.bd/', '_blank');
            }
        },
        error: function (response, status)
        {
            console.log('Request failed.  Returned status of',status);
        }
    });
}