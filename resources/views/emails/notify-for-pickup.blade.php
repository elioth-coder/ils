<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Notification: Approved Request for Book Pickup</title>
    <style>
        * {
            color: black;
        }

        .text-capitalize {
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="message">
            <p>Dear <span class="text-capitalize">{{ $data['name'] }}</span>,</p>

            <p>
                We are pleased to inform you that your request for the following item(s) has been approved and is now ready for pickup:
            </p>
            <ul>
                <li>
                    <b>Title: </b>{{ $data['title'] }}
                </li>
                <li>
                    <b>Pickup until: </b>{{ date('M. d, Y', strtotime($data['deadline'])); }}
                </li>
            </ul>
            <p>
                You may collect your item(s) from the {{ $data['library'] }} during our operating hours: <br>
                from Monday to Friday, 8:00 AM - 5:00 PM
            </p>
            <p>
                Please bring a valid ID or your library card for verification. If you are unable to pick up the item(s) until {{ date('M. d, Y', strtotime($data['deadline'])); }}, kindly inform us to avoid the cancellation of your request.
            </p>
            <p>
                If you have any questions or need assistance, feel free to contact us at
                <a href="mailto:neustlibpapayaoffcampus@gmail.com">neustlibpapayaoffcampus@gmail.com</a>  or 0916 690 2122.
            </p>
            <p>
                Thank you for using our library services. We look forward to serving you!
            </p>

            Best regards, <br>
            <span class="text-capitalize">{{ $data['sender'] }}</span> <br>
            <span class="text-capitalize">{{ $data['role'] }}</span> <br>
            {{ $data['library'] }} <br>
            {{ $data['email'] }}
        </div>
    </div>
</body>

</html>
