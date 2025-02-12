<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background: #007bff;
            color: #ffffff;
            padding: 15px;
            font-size: 20px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
            line-height: 1.6;
            text-align: center;
        }

        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            display: inline-block;
            margin: 10px 0;
        }

        .login-btn,
        .download-btn {
            display: block;
            text-align: center;
            background: #28a745;
            color: #ffffff;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .download-btn {
            background: #ff9800;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777777;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            Password Reset Request
        </div>

        <div class="content">
            <p>Hello <strong>{USERNAME}</strong>,</p>
            <p>Your account details are as follows:</p>

            <p class="info-box">📱 Mobile: {MOBILE_NUMBER}</p>
            <p class="info-box">🔑 New Password: {NEW_PASSWORD}</p>

            <a href="{LOGIN_URL}" class="login-btn">Login Now</a>
            <a href="{APP_DOWNLOAD_URL}" class="download-btn">Download Android App</a>

            <p>If you did not request this, please ignore this email or contact support.</p>
        </div>

        <div class="footer">
            &copy; <?= date('Y') ?> Rainbow Eduzone. All rights reserved.
        </div>
    </div>

</body>

</html>