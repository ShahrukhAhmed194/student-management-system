<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $student->student_id . "_certificate.pdf" }}</title>
        <style>
            @font-face {
                font-family: 'Playfair Display';
                src: url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400&display=swap');
            }
            @font-face {
                font-family: 'Autumn Flowers';
                src: url("{{ base_path('public/assets/fonts/AutumnFlowers.otf') }}");
            }
            body, html {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                font-family: 'Playfair Display', serif;
            }
            .certificate-container {
                position: relative;
                width: 100%;
                height: 100%;
                background: url("data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/assets/img/certificate/certificate_bg.png'))) }}") no-repeat center center;
                background-size: cover;
            }
            .name {
                position: absolute;
                top: 48%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: 'Autumn Flowers', cursive;
                font-size: 50px;
                color: #41144D;
                text-align: center;
                width: 80%;
            }
            .course {
                position: absolute;
                top: 60%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: 'Playfair Display', serif;
                font-size: 22px;
                font-weight: 700;
                color: #2880B2;
                text-align: center;
                width: 80%;
            }
            .date {
                position: absolute;
                top: 86%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: 'Playfair Display', serif;
                font-size: 12px;
                color: black;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="certificate-container">
            <div class="name">{{ $student->user->name }}</div>
            <div class="course">{{ $level->title }}</div>
            <div class="date">{{ $certificate->created_at->format('d F Y') }}</div>
        </div>
    </body>
</html>