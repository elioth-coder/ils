<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Account Activation</title>
    <style>
        * {
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="message">
            <p>{{ strtoupper($data['name']) }},</p>
            <p>
                You (or someone pretending to be you) have asked to register an account at
                <a href="{{ $data['app_url'] }}">{{ $data['app_domain'] }}</a>. If this wasn't you, please ignore this
                email and your address will be removed from our records.
            </p>

            <p>To activate this account, please click the following link:</p>
            <p><a href="{{ $data['activation_link'] }}">{{ $data['activation_link'] }}</a></p>
            <p>Note: your current pin is <b>{{ $data['pin'] }}</b></p>
            <p>Sincerely, <a href="{{ $data['app_url'] }}">{{ $data['app_domain'] }}</a> Management</p>
        </div>
    </div>
</body>

</html>
