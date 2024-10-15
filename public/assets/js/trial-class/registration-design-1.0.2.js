$(document).ready(function () {
    $('#languages').hide();
    $('#selected_languages').hide();
    $('#ind_time').hide();
    $('#uk_time').hide();
    $("#reg_progress").hide();
    var current_fs, next_fs, previous_fs, index_of_fs, inputs_of_current_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;
    setProgressBar(current);
    $(".next").click(function () {
        $(".loader-div").show();
        setTimeout(function() {
            $(".loader-div").hide();
        }, 350);
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        index_of_fs = $("fieldset").index(next_fs);
        
        if(index_of_fs == 1){
            inputs_of_current_fs = {
                "index"   : index_of_fs,
                "student_name" : $("#student_name").val(),
                "gender" : $("#gender").val(),
                "school" : $("#school").val(),
                "hasDevice" : $("input[name='hasDevice']:checked").val(),
                "hear_from" : $("#hear_from").val()
            }
            sendInputsForValidation(inputs_of_current_fs);
            
        }else if(index_of_fs == 2){
            inputs_of_current_fs = {
                "index"   : index_of_fs,
                "country" : $("#country").val(),
                "age" : $("#age").val(),
                "date" : $("input[name='date']:checked").val(),
                "trial_class_id" : $("input[name='trial_class_id']:checked").val()
            }
            sendInputsForValidation(inputs_of_current_fs);
        }else if(index_of_fs == 3){
            inputs_of_current_fs = {
                "index"   : index_of_fs,
                "gurdian_name" : $("#gurdian_name").val(),
                "occupation" : $("#occupation").val(),
                "phone" : $("#phone").val(),
                "email" : $("#email").val()
            }
            sendInputsForValidation(inputs_of_current_fs);
        }else{
            showTheNextFieldset();
        }
    });
    $(".previous").click(function () {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(--current);
    });
    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
    }
    function sendInputsForValidation(input_of_fs)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/validate-fieldsets',
            data: input_of_fs ,
            success: function(data) {
                if(data === 'Success'){
                    showTheNextFieldset();
                }else{
                    emptyValidationMessages();
                    showValidationMessages(data);
                }
        
            },
            error : function(response){
                console.log('failed')
            }
        });
    }
    function showTheNextFieldset(){
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(++current);
        if($("fieldset").index(next_fs) == 3){
            $("#msform").submit();  
        }
    }
    
    function showValidationMessages(messages){
        if(messages.student_name !== undefined){
            $("#student_name_error").text(messages.student_name[0]);
        }
        if(messages.gender !==  undefined){
            $("#gender_error").text(messages.gender[0]);
        }
        if(messages.school !== undefined){
            $("#school_error").text(messages.school[0]);
        }
        if(messages.hasDevice !==  undefined){
            $("#hasDevice_error").text(messages.hasDevice[0]);
        }
        if(messages.hear_from !==  undefined){
            $("#hear_from_error").text(messages.hear_from[0]);
        }
        if(messages.country !==  undefined){
            $("#country_error").text(messages.country[0]);
        }
        if(messages.language !==  undefined){
            $("#language_error").text(messages.language[0]);
        }
        if(messages.age !==  undefined){
            $("#age_error").text(messages.age[0]);
        }
        if(messages.date !==  undefined){
            $("#date_error").text(messages.date[0]);
        }
        if(messages.trial_class_id !==  undefined){
            $("#trial_class_id_error").text(messages.trial_class_id[0]);
        }
        if(messages.gurdian_name !==  undefined){
            $("#gurdian_name_error").text(messages.gurdian_name[0]);
        }
        if(messages.occupation !==  undefined){
            $("#occupation_error").text(messages.occupation[0]);
        }
        if(messages.phone !==  undefined){
            $("#phone_error").text(messages.phone[0]);
        }
        if(messages.email !==  undefined){
            $("#email_error").text(messages.email[0]);
        }
        
    }
    function emptyValidationMessages(){
            $("#student_name_error").text('');
            $("#gender_error").text('');
            $("#school_error").text('');
            $("#hasDevice_error").text('');
            $("#hear_from_error").text('');
            $("#country_error").text('');
            $("#language_error").text('');
            $("#age_error").text('');
            $("#date_error").text('');
            $("#trial_class_id_error").text('');
            $("#gurdian_name_error").text('');
            $("#occupation_error").text('');
            $("#phone_error").text('');
            $("#email_error").text('');
    }
});

// Below are functions of previous version
function getTrialClassDates() 
{
    let country =  $('#country').val();
    let age =  $('#age').val();
    if(country == 'India'){
        $('#languages').show();
        $('#selected_languages').show();
        $('#bd_time').hide();
        $('#ind_time').show();
        $('#uk_time').hide();
    }else if(country == 'United Kingdom'){
        $('#languages').hide();
        $('#selected_languages').hide();
        $('#bd_time').hide();
        $('#ind_time').hide();
        $('#uk_time').show();
    }else{
        $('#languages').hide();
        $('#selected_languages').hide();
        $('#bd_time').show();
        $('#ind_time').hide();
        $('#uk_time').hide();
    }
    if(country.length > 0 && age.length > 0){
        $.ajax({
            type: 'POST',
            url: '/getdate',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "age": age,
                "country": country
            },
            beforeSend:function(){
                $(".loader-div").show();
                setTimeout(function() {
                    $(".loader-div").hide();
                }, 400);
            },
            success: function(data) {
                var html_str_date = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        html_str_date += `<div class="col-md-4 text-center" onclick="getTrialTime()">
                                            <input type="radio" name="date" value="${data[i].date}" id="flexRadioDefault${i}">
                                            <label role='button' for="flexRadioDefault${i}">                                            
                                            ${ new Date(data[i].date).toLocaleDateString('en-us', { weekday:"short", month:"short", day:"numeric" }) }
                                            </label>
                                        </div>`;
                    }
                } else {
                    if($('#country').val() == 'United Kingdom'){
                        html_str_date += `<div class="form-check col-md-12">
                                            <p>Sorry,&#128532; No Dates Are Available At This Moment.</p>
                                         </div>`;
                    }else{
                        html_str_date += `<div class="form-check col-md-12">
                                            <p>No Date Is Available,&#128532; Please Contact Us: +880 1301528308 , +880 1301507842.&#128222;</p>
                                         </div>`;
                    }
                }
                $("#available_dates").html(html_str_date);
            },
            error : function(response){
                console.log('failed')
            }
        });
    }
    emptyTime()
}
function getTrialTime() 
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/gettime',
        data: {
            "date": document.querySelector('input[name="date"]:checked').value, //document.getElementById('trial_date').value
            "age": document.getElementById('age').value,
            "country": document.getElementById('country').value
        },
        beforeSend:function(){
            $(".loader-div").show();
            setTimeout(function() {
                $(".loader-div").hide();
            }, 400);
        },
        success: function(data) {
            var html_str = '';
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    html_str += `<div class="col-md-3" onclick="setReadOnlyTime(${i})">
                                    <input type="hidden" value="${data[i].time}" id="classtime${i}">
                                    <input type="radio" name="trial_class_id" value="${data[i].id}" id="trialclasstime${i}">
                                    <label role='button' for="trialclasstime${i}">
                                    ${convertTime(data[i].time)} <br>
                                    </label>
                                </div>`;
                }
            } else {
                html_str += `<div class="form-check radioDiv">
                                <p>No Date Available, Please Contact Us: +880 1897-717780; +880 1897-717781.</p>
                            </div>`;
            }
            $("#available_times").html(html_str);
        }
    });
}
function emptyTime() 
{
    var html_str = '';
    html_str += `<div class="form-check">
                    <p>Please select date to view times &#x1F4C5;.</p>
                </div>`;
    $("#available_times").html(html_str);
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
function setReadOnlyTime(id){
    var time = convertTime($('#classtime'+id).val())
    $('#readonly_trial_class_id').val(time);
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