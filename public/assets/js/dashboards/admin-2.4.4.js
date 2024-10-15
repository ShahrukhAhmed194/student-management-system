$(document).ready(function(){  
    $.ajax({
        type : "GET",
        url  : "/total-myWorkList",
        success: function (response) { 
            if(response >0){
                $("#total_myWorkList").removeClass("text-muted");           
                $('#total_myWorkList').text(response);
            }else{
                $("#total_myWorkList").hide();
                $("#no_total_myWorkList").text('0').addClass("text-dark");
            }    
        },
        error: function (data){
            console.log('fail');
        }
    });

    if ($('.card-list').data('total-registration') == true) {
        $.ajax({
            type : "GET",
            url  : "/total-registrations",
            success: function (response) {
                if(response >0){
                    $("#total_registration").removeClass("text-muted");
                    $('#total_registration').text(response);
                }else{
                    $("#total_registration").hide();
                    $("#no_total_registration").text('0');
                }
            },
            error: function (data){
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('total-students') == true) {
        $.ajax({
            type: "GET",
            url: "/total-students",
            success: function (response) {
                if (response > 0) {
                    $("#total_students").removeClass("text-muted");
                    $('#total_students').text(response);
                } else {
                    $("#total_students").hide();
                    $("#no_total_students").text('0');
                }

            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('active-students') == true) {
        $.ajax({
            type: "GET",
            url: "/active-students",
            success: function (response) {
                if (response > 0) {
                    $("#active_students").removeClass("text-muted");
                    $('#active_students').text(response);
                } else {
                    $('#active_students').hide();
                    $('#no_active_students').text('0');
                }

            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('on-hold-students') == true) {
        $.ajax({
            type: "GET",
            url: "/students-on-hold",
            success: function (response) {
                if (response > 0) {
                    $("#students_on_hold").removeClass("text-muted");
                    $('#students_on_hold').text(response);
                } else {
                    $("#students_on_hold").hide();
                    $("#no_students_on_hold").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('terminated-students') == true) {
        $.ajax({
            type: "GET",
            url: "/terminated-students",
            success: function (response) {
                if (response > 0) {
                    $("#terminated_students").removeClass("text-muted");
                    $('#terminated_students').text(response);
                } else {
                    $("#terminated_students").hide();
                    $("#no_terminated_students").text('0');
                }

            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('graduated-students') == true) {
        $.ajax({
            type: "GET",
            url: "/graduated-students",
            success: function (response) {
                if (response > 0) {
                    $("#graduated_students").removeClass("text-muted");
                    $('#graduated_students').text(response);
                } else {
                    $("#graduated_students").hide();
                    $("#no_graduated_students").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('trial-class-students-yesterday') == true) {
        $.ajax({
            type: "GET",
            url: "/trial-class-students-yesterday",
            success: function (response) {
                if (response > 0) {
                    $("#trial_class_students_yesterday").removeClass("text-muted");
                    $('#trial_class_students_yesterday').text(response);
                } else {
                    $("#trial_class_students_yesterday").hide();
                    $("#no_trial_class_students_yesterday").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('trial-class-students-today') == true) {
        $.ajax({
            type: "GET",
            url: "/trial-class-students-today",
            success: function (response) {
                if (response > 0) {
                    $("#trial_class_students_today").removeClass("text-muted");
                    $('#trial_class_students_today').text(response);
                } else {
                    $("#trial_class_students_today").hide();
                    $("#no_trial_class_students_today").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('trial-class-students-tomorrow') == true) {
        $.ajax({
            type : "GET",
            url  : "/trial-class-students-tomorrow",
            success: function (response) {
                if(response >0){
                    $("#trial_class_students_tomorrow").removeClass("text-muted");
                    $('#trial_class_students_tomorrow').text(response);
                }else{
                    $("#trial_class_students_tomorrow").hide();
                    $("#no_trial_class_students_tomorrow").text('0');
                }
            },
            error: function (data){
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('student-payment-received') == true) {
        $.ajax({
            type: "GET",
            url: "/payments-receivied",
            success: function (response) {
                if (response > 0) {
                    $("#payment_received").removeClass("text-muted");
                    $('#payment_received').text(response);
                } else {
                    $("#payment_received").hide();
                    $("#no_payment_received").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }

    if ($('.card-list').data('student-payment-due') == true) {
        $.ajax({
            type: "GET",
            url: "/due-payments",
            success: function (response) {
                if (response > 0) {
                    $("#due_payments").removeClass("text-muted");
                    $('#due_payments').text(response);
                } else {
                    $("#due_payments").hide();
                    $("#no_due_payments").text('0');
                }
            },
            error: function (data) {
                console.log('fail');
            }
        });
    }
});