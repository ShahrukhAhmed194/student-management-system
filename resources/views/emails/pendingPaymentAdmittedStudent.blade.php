<!DOCTYPE html>
<html>
<head>
    <title>Dreamers Academy</title>
</head>
<body>
    <p>Dear {{ $contentData['parentName'] }},<br>
        {{ $contentData['message'] }}
    </p>
    <p>
        Student Name: {{ $contentData['studentName'] }}, <br>
        Due Months: {{ $contentData['due_installments'] }} Months.
    </p>
    <p>
       <strong>Note: </strong>Please ignore this message if you have already cleard your dues.
    </p>
    <h4>
    	Team Dreamers
    </h4>
</body>
</html>
