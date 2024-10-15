let urlParams = new URLSearchParams(window.location.search);
let urlPath = window.location.pathname;
let bkash_id = urlParams.get('bkash_id');

$(document).ready(function(){
    autoFillPaymentFormWithBkashTransaction();
});

function autoFillData() 
{
    let student_id = $('#student_id').val();
    $.ajax({
        type: 'GET',
        url: '/payment-form-auto-fill/'+student_id,
        success: function(response) {
            if(bkash_id !== null){
                let for_month = response.due_for_months ? response.due_for_months.split(',') : 'NULL';

                $('.hint-text').text('Monthly Fee: '+response.payable_amount+' Taka.');
                $('#for_month').val(for_month).trigger('change');
            }else{
                $('#fees').val(response.payable_amount);
                $('#transaction_purpose').val('monthly-fee');
            }
            $('#installment').val(response.due_installments);

        }
    });
    
}

function makeInstallmentEditable()
{
    if($('#enable_installment').is(':checked')){
        $('#installment').removeAttr('readonly');
    }else{
        $('#installment').attr('readonly', 'readonly');
    }
}

function loadAllChild(student_id = null)
{
    $.ajax({
        url: "/load-allchild",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: {student_id : student_id},
        enctype: "multipart/form-data",
        success: function (response) {
            $("#student_id").html(response);
        }
    });
}

function autoFillPaymentFormWithBkashTransaction() 
{
    if(bkash_id !== null){
        $.ajax({
            url: '/transaction-module/bkash/get-bkash-payment-info',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: {bkash_id : bkash_id},
            success: function (response) {
                if(response.hasOwnProperty('student_id')){
                    loadAllChild(response.student_id);
                }else{
                    loadAllChild();
                }

                let for_month = response.due_for_months ? response.due_for_months.split(',') : 'NULL';
                let fees = Math.round(response.fees);

                $('#for_month').val(for_month).trigger('change');
                $('#fees').val(fees);
                $('#transaction_type').val('bkash');
                $('#transaction_id').val(response.transaction_id);
                $('#installment').val(response.due_installments);
                $('#notes').val(response.notes);
                $('#date').val(response.date);
                $('#transaction_purpose').val('monthly-fee');
            }
        });
    }else{
        if (urlPath === '/payment-add-new'){
            loadAllChild();
        }
    }
    
}