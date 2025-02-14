<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background: #ff6f00;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
        }
        .otp-box {
            font-size: 22px;
            font-weight: bold;
            color: #ff6f00;
            margin: 20px 0;
            display: inline-block;
            padding: 10px 20px;
            border: 2px dashed #ff6f00;
            border-radius: 5px;
            background: #fff3e0;
        }
        .message {
            font-size: 16px;
            color: #333333;
            margin: 10px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }
        .footer a {
            color: #ff6f00;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="header">OTP Verification</div>
    
    <p class="message">Dear {USER},</p>
    <p class="message">Use the following OTP to verify your login:</p>
    
    <div class="otp-box">{OTP}</div>

    <p class="message">This OTP is valid for <strong>2 minutes</strong>. Do not share it with anyone.</p>

    <div class="footer">
        If you didn't request this OTP, please ignore this email.
    </div>
</div>

</body>
</html>
