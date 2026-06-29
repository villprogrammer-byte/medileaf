<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Enquiry</title>
</head>

<body>

    <h2>New Contact Enquiry</h2>

    <p><strong>First Name:</strong> {{ $data['first_name'] }}</p>

    <p><strong>Last Name:</strong> {{ $data['last_name'] }}</p>

    <p><strong>Email:</strong> {{ $data['email'] }}</p>

    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>

    <p><strong>Reason:</strong> {{ $data['reason'] }}</p>

    <p><strong>Message:</strong></p>

    <p>{{ $data['message'] }}</p>

</body>

</html>