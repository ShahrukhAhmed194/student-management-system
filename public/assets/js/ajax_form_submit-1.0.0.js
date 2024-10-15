$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('submit','.ajax-form', function(e){
        e.preventDefault();

        $(':submit').attr('disabled', 'disabled');
        $(':submit').text('Please wait...');

        $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");

        let $this = $(this);
        let formData = new FormData(this);

        $this.find(".has-danger").removeClass('has-error');
        $this.find(".form-errors").remove();

        $.ajax({
            type: $this.attr('method'),
            url: $this.attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $(".loader-populate").html("");

                if( response.redirect == true ){
                    swal.fire('', `${response.message}`, `${response.status}`)
                    setTimeout(function () {
                        return window.location.href = response.url
                    }, 1000);
                }
                else {
                    $(':submit').removeAttr('disabled');
                    $(':submit').text('Submit');

                    swal.fire('', `${response.message}`, `${response.status}`)
                    if ($("#datatable").length) {
                        $("#datatable").DataTable().ajax.reload();
                    }
                }

                console.clear()
            },
            error: function (response) {
                $(".loader-populate").html("");

                $(':submit').removeAttr('disabled');
                $(':submit').text('Submit');

                if (response.status === 500) {
                    let error = JSON.parse(response.responseText);
                    swal.fire('', `${error.message}`, `error`)
                }
                else {
                    let data = JSON.parse(response.responseText);
                    $.each(data.errors, (key, value) => {
                        swal.fire("", `${value}`, "warning");
                        $("[name^=" + key + "]").parent().addClass('has-error');
                        $("[name^=" + key + "]").parent().append('<small class="danger text-muted form-errors">' + value[0] + '</small>');
                    })
                }

                console.clear();
            }
        })
    })

})
