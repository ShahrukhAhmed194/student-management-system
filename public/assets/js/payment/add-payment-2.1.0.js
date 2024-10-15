function autoFillData() 
{
    let id = $('#student_id').val();
    $.ajax({
        type: 'GET',
        url: '/payment-form-auto-fill/'+id,
        success: function(response) {
            $('#fees').val(response.payable_amount);
            $('#installment').val(response.due_installments);
            $('#transaction_purpose').val('monthly-fee');
            fillUpBkashFormwithoutAgreement();
        },
        error: function(){
            console.log('failed')
        }
    });
}

function fillUpBkashForm()
{
    $('#bkash_student_id').val($('#student_id').val());
    $('#bkash_fees').val($('#fees').val());
    $('#bkash_installment').val($('#installment').val());
    $('#bkash_transaction_purpose').val($('#transaction_purpose').val());
    $('#bkash_transaction_type').val($('#transaction_type').val());
    $('#bkash_agreement').val($('#agreement').val());
    $('#bkash_for_month').val($('#for_month').val());
    $('#bkash_notes').val($('#notes').val());
}

function fillUpBkashFormwithoutAgreement ()
{
    $('#bkash_student_id').val($('#student_id').val());
    $('#bkash_fees').val($('#fees').val());
    $('#bkash_installment').val($('#installment').val());
    $('#bkash_transaction_purpose').val($('#transaction_purpose').val());
    $('#bkash_transaction_type').val($('#transaction_type').val());
    $('#bkash_for_month').val($('#for_month').val());
    $('#bkash_notes').val($('#notes').val());
}

function makeInstallmentEditable()
{
    if($('#enable_installment').is(':checked')){
        $('#installment').removeAttr('readonly');
    }else{
        $('#installment').attr('readonly', 'readonly');
    }
}