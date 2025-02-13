<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Withdrawal Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
            color: #555;
        }
        .btn {
            display: block;
            width: 100%;
            max-width: 200px;
            text-align: center;
            background: #28a745;
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px auto;
        }
        .btn:hover {
            background: #218838;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>New Withdrawal Request</h2>
        <p>Dear Admin,</p>
        <p>You have received a new request from a student. Below are the details:</p>

        <div class="details">
            <p><strong>Student Name:</strong> {STUDENT_NAME}</p>
            <p><strong>Mobile Number:</strong> {MOBILE_NUMBER}</p>
            <p><strong>Requested Amount:</strong> ₹{AMOUNT}</p>
            <p><strong>Request Date:</strong> {DATE}</p>
        </div>

        <p>Please review and take action on this request.</p>

        <a href="{ADMIN_LINK}" class="btn">View Request</a>

        <div class="footer">
            <p>&copy; <?=date('Y')?> Rainbow Eduzone. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
