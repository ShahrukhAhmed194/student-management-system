<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div style="width: 450px; height: 450px;">
    <h4>Greetings ,<br>
    From Dreamers Academy.</h4><br>  
        <p>You are receiving this email because we received a password reset request for your account.</p><br>
            <div style="text-align: center;">
                <a href="{{route('update.password', ['token' => $contentData['token']])}}" style="background-color:black;color:white; text-decoration: none; padding: 10px; ">Reset Password</a>
            </div>
        <p>If you did not request a password reset, no further action is required.</p>
    <h4>Regards,<br>
    Dreamers Team.</h4>
</div>
<hr><br>
</body>
</html>