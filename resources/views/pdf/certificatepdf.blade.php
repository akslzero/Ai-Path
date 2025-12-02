<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>

    <style>
        @page { margin: 0px; }

        body {
            margin: 0;
            padding: 60px;
            text-align: center;
            background-image: url("{{ public_path('certificate-bg.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            font-family: "Times New Roman", serif;
        }

        .title {
            font-size: 40px;
            font-weight: bold;
            margin-top: 30px;
        }

        .subtitle {
            font-size: 20px;
            margin-top: 10px;
        }

        .username {
            font-size: 32px;
            font-weight: bold;
            margin: 30px 0;
        }

        .course-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer {
            position: absolute;
            bottom: 40px;
            width: 100%;
            text-align: center;
            font-size: 16px;
        }

        .signature {
            margin-top: 40px;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <div class="title">CERTIFICATE OF COMPLETION</div>

    <div class="subtitle">This certificate is proudly presented to</div>

    <div class="username">{{ $user->name }}</div>

    <div class="subtitle">For successfully completing the course:</div>

    <div class="course-title">"{{ $course->title }}"</div>

    <div class="signature">
        <p>Issued on {{ $date }}</p>
    </div>

    <div class="footer">
        Future Academy — Learn. Grow. Achieve.
    </div>

</body>
</html>
