<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Link Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            font-size: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }
        .btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #218838;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        Payment Required for Your {purchase_item}
    </div>
    <div class="content">
        <p>Hello <strong>{USER_NAME}</strong>,</p>
        <p>You have enrolled in the {purchase_item}: <strong>{purchase_item_title}</strong>.</p>
        <p>To complete your registration, please make the payment by clicking the button below.</p>
        <!-- <p></p> -->
        <p style="color: red; font-weight: bold;">Note: This payment link is valid for one-time use only.</p>
        <p>If you have already made the payment, please ignore this message.</p>
        <a href="{PAYMENT_LINK}" class="btn">Pay Now</a>
    </div>
    <div class="footer">
        If you have any questions, feel free to contact our support team.<br>
        <strong>Thank you!</strong>
    </div>
</div>

</body>
</html>
