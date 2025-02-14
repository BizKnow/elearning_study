<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
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
            background: #28a745;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
        }

        .message {
            font-size: 16px;
            color: #333333;
            margin: 10px 0;
        }

        .details-box {
            font-size: 18px;
            font-weight: bold;
            color: #555;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            display: inline-block;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="header">🎉 Registration Successful!</div>

        <p class="message">Dear {name},</p>
        <p class="message">Thank you for registering with us. Your account has been successfully created. Here are your
            login details:</p>

        <div class="details-box">
            📱 Mobile: {contact_number} <br>
            🔑 Password: {password}
        </div>

        <p class="message">Please keep this information secure. Do not share it with anyone.</p>

    </div>

</body>

</html>