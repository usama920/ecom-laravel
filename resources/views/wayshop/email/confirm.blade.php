<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration</title>
</head>
<body>
    <p>
        Dear {{$name}},<br>
        Please click on the link below to activate your account <br>
        <a href="{{url('/confirm/'.$code)}}" target="blank">Active Account</a>
        Regards, <br>
        Wayshop Team
    </p>
</body>
</html>