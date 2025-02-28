<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .student-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            🎉 New Student Registered!
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>A new student has just registered on your platform. Below are the details:</p>

            <div class="student-details">
                <p><strong>Name:</strong> {STUDENT_NAME}</p>
                <p><strong>Email:</strong> {STUDENT_EMAIL}</p>
                <p><strong>Phone:</strong> {STUDENT_PHONE}</p>
            </div>

            <p>You can view the student details by clicking the button below:</p>
            <a href="{STUDENT_PROFILE_LINK}" class="btn">View Profile</a>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Rainbow Eduzone. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
