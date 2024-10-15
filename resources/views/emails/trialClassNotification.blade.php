<!DOCTYPE html>
<html>
<head>
    <title>Dreamers</title>
</head>
<body>

    <p>Dear instructor,<br>
    You have a student on : <strong><?php echo $instructorContent['date']; ?></strong> 
    at <strong><?php echo $instructorContent['time']; ?>.</strong><br>
    Your meeting link is as follows: <a href="<?php echo $instructorContent['zoom_link']; ?>" target='_blank'><?php echo $instructorContent['zoom_link']; ?></a>.<br>
    Class Login Details : <?php echo $instructorContent['class_login_details']; ?> <br>
    Please, check your mic and speakers before coming.
    <br><br></p>
    <p>For further queries, please contact us at: <?php echo $instructorContent['support_phone']; ?>.<br></p>
    <h4>Thanks,<br>
    Dreamers Academy.</h4>
</body>
</html>