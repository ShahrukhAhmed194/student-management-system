//gender select
const gender = document.querySelectorAll('.gender');
gender.forEach(option => {
    option.addEventListener('click', () => {
        gender.forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
    });
});
//gender select

//has device select
const has_devices = document.querySelectorAll('.has-device');
has_devices.forEach(option => {
    option.addEventListener('click', () => {
        has_devices.forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
        if(option.querySelector('input').value == 0) {
            $('.no-device-message').removeClass('d-none');
        } else {
            $('.no-device-message').addClass('d-none');
        }
    });
});
//has device select

//language select
const language = document.querySelectorAll('.language');
language.forEach(option => {
    option.addEventListener('click', () => {
        language.forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
    });
});
//language select

//time slot select
$(document).on('click', '.time-slot', function() {
    let slot = $(this);
    slot.addClass('selected');
    $('.time-slot').not(slot).removeClass('selected');
});
//time slot select

//form validation
$(".trail-class-registration").validate({
    ignore: ":hidden",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "phone") {
            element.parent().parent().append(error);
        }
        else if (element.attr("type") == "radio") {
            element.parent().parent().parent().append(error);
        } else {
            element.parent().append(error);
        }
    },
    rules: {
        phone: {
            required: true,
            intlTelNumber: true
        },
        email: {
            required: true,
            email: !0,
        },
        gurdian_name: {
            required: true,
            customChars: true
        },
        occupation: {
            required: true,
            customChars: true
        },
        student_name: {
            required: true,
            customChars: true
        },
        school: {
            required: true,
            customChars: true
        },
        age: "required",
        gender: "required",
        country: "required",
        hear_from: "required",
        class_date: "required",
        trial_class_id: "required",
    },
    messages: {
        gurdian_name : {
            required: 'Guardian name is required',
            customChars: 'Please enter only alphabetical characters, dots, commas, hyphens, and Bangla characters'
        },
        phone : {
          required: 'Phone is required',
          intlTelNumber: 'Please enter a valid Phone Number'
        },
        occupation : 'Occupation is required',
        country : 'Country is required',
        hear_from : 'Hear from is required',
        student_name : {
            required: 'Student name is required',
            customChars: 'Please enter only alphabetical characters, dots, commas, hyphens, and Bangla characters'
        },
        age : 'Age is required',
        school :{
            required: 'School is required',
            customChars: 'Please enter only alphabetical characters, dots, commas, hyphens, and Bangla characters'
        },
        gender : 'Gender is required',
        class_date : 'Class date is required',
        trial_class_id : 'Class Time is required',
        email: {
            required: "Email is required",
        }
    }

});

$.validator.addMethod("intlTelNumber", function(value, element) {
    return isValidNumber;
});

$.validator.addMethod("customChars", function(value, element) {
    var regex = /^[a-zA-Z.,()\-'"\s\u0980-\u09FF]+$/i;
    return this.optional(element) || regex.test(value);
}, "Please enter only alphabetical characters, dots, commas, hyphens, and Bangla characters.");

$(".student_name .school .guardian_name").on('input keydown keyup keypress paste', function() {
    $(this).valid();  // Trigger validation
});

//form validation

//form validation in next button click
let section = 'section-2';
let sectionNumber = parseInt(section.split('-')[1]);
$('.trail-class-registration input, .trail-class-registration select').on('change blur input keydown keyup keypress paste', function() {
    if ($('.trail-class-registration').valid()) {
        $(`.${section}`).removeClass('d-none');
        if(section !== 'section-5') {
            sectionNumber++;
            section = `section-${ sectionNumber }`;
        }
    }
});
//form validation in next button click


$('.button-group .btn').on('click', function () {
    let age = $(this).data('age');
    $(this).addClass('bg-warning').removeClass('bg-warning-subtle text-warning').siblings().removeClass('bg-warning').addClass('bg-warning-subtle text-warning');
    if(age === 'seven-eight') {
        $('#age').html(`
            <option value="">Choose</option>
            <option value="7">৭</option>
            <option value="8">৮</option>
        `);
    }
    if(age === 'nine-ten') {
        $('#age').html(`
            <option value="">Choose</option>
            <option value="9">৯</option>
            <option value="10">১০</option>
        `);
    }
    if(age === 'eleven-sixteen') {
        $('#age').html(`
            <option value="">Choose</option>
            <option value="11">১১</option>
            <option value="12">১২</option>
            <option value="13">১৩</option>
            <option value="14">১৪</option>
            <option value="15">১৫</option>
            <option value="16">১৬</option>
        `);
    }
});

function convertTime(time) 
{
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

    if (time.length > 1) { 
        time = time.slice (1);  
        time[5] = +time[0] < 12 ? ' AM' : ' PM';
        time[0] = +time[0] % 12 || 12; 
    }
    return time.join (''); 
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


