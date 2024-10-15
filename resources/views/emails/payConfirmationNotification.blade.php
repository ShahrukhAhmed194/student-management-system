<!DOCTYPE html>
<html>
<head>
    <title>Dreamers</title>
</head>
<body>

    <h2>Assalamu Alaikum,<br>
        Greetings from Dreamers Academy.<br><br></h2>
        <p>Mr./Mrs. {{ $payConfirmationContent['parent_name'] }} Your payment for your {{$payConfirmationContent['transaction_purpose'] == 'robotics-kit' ? "child's Robotics Kit ": "child"}} has been completed..<br><br></p>
        <a href="https://dreamers.lead.academy/payment/{{ $payConfirmationContent['pay_id'] }}/invoice" style='margin-left:40%; '>
        <button  style='background-color:black; color:white; padding:8px'>Invoice</button></a><br><br>
        <p>For further queries, please contact us at: +880 1897-717780; +880 1897-717781.<br></p>
        <h2>Thanks,<br>
        Dreamers Academy.</h2>
</body>
</html>