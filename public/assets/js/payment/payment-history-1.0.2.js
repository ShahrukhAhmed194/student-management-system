function payment_details(){
    var fd = new FormData();
    let id = $('#select-student').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let transaction_type = $('#transaction_type').val();
    let currency = $('#currency').val();
    
    fd.append("id", id);
    fd.append("from_date", from_date);
    fd.append("to_date", to_date);
    fd.append("transaction_type", transaction_type);
    fd.append("currency", currency);

    $.ajax({
        url: "/payment-details",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: fd,
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,

        success: function (response) {
            $('tbody').empty();
            $.each(response, function( index, value ) {
                $('tbody').append('<tr>'); 
                $('tbody').append('<td>'+value.date+'</td>');   
                $('tbody').append('<td>'+value.student.user.name+'</td>');   
                $('tbody').append('<td>'+value.fees+'</td>');   
                $('tbody').append('<td>'+value.currency+'</td>');   
                $('tbody').append('<td>'+value.transaction_type+'</td>');   
                $('tbody').append('<td>'+value.transaction_id+'</td>');   
                $('tbody').append('<td>'+value.transaction_purpose+'</td>');   
                $('tbody').append('<td>'+value.invoice_id+'</td>');  
                $('tbody').append('<td>'+value.installment+'</td>'); 
                $('tbody').append('<td>'+$.parseJSON(value.for_month)+'</td>');  
                $('tbody').append('<td>'+value.payment_status+'</td>');    
                $('tbody').append('<td>'+(value.notes == null? '' : value.notes)+'</td>');   
                $('tbody').append('<td><a target=_blank href='+'/payment/'+value.id+'/invoice'+'>view</a></td>');   
                $('tbody').append('<td><a target=_blank href='+'/payment-edit/'+value.id+'><i class="bi bi-pencil-square"></i></a></td>');   
                $('tbody').append('</tr>');   
            });
        },
        error: function (data){
            console.log('fail');
        }
    });
}