<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your New Password</title>
</head>
<body>
<h2>Hello {{ $user->name }},</h2>
<p>We have generated a new password for your account:</p>

<p style="font-size:18px; font-weight:bold; color:#4f46e5;">
    {{ $newPassword }}
</p>

<p>You can now log in with this new password. For your security, please change it after logging in.</p>

<p>Thanks,<br>CodeZone Team</p>
</body>
</html>
