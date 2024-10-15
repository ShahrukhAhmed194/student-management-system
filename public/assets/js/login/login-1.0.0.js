function showPassword(){
    if($("#show_password").is(':checked')){
        $('#yourPassword').attr('type', 'text');
    }else{
        $('#yourPassword').attr('type', 'password');
    }
}