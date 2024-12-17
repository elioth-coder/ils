<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Notification: Overdue Items for Return</title>
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
                We hope this message finds you well. Our records indicate that the following item(s) you borrowed from the library are overdue for return:
            </p>
            <ul>
                <li>
                    <b>Title: </b>{{ $data['title'] }}
                </li>
                <li>
                    <b>Due date: </b>{{ date('M. d, Y', strtotime($data['due_date'])); }}
                </li>
            </ul>
            <p>
                We kindly request you return the overdue item at your earliest convenience to avoid further penalties. If the items have already been returned, please disregard this notice.
            </p>
            <p>
                Should you need to renew your loan or have any questions, feel free to contact us at
                <a href="mailto:neustlibpapayaoffcampus@gmail.com">neustlibpapayaoffcampus@gmail.com</a>  or 0916 690 2122.
            </p>

            <p>
                Thank you for your prompt attention to this matter.
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
