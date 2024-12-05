<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable Template</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full height of the viewport */
        }

        @page {
            margin: 0;
            padding:0;
        }

        /* Header and Footer Styles */
        #header {
            position: fixed;
            height: 11vh;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 0;
            margin-bottom: 2rem;
        }

        #footer {
            height: 40px;
            width: 100%;
            position: fixed;
            background-color: #f8f9fa;
            text-align: center;
            padding: 0;
            bottom: 0;
            margin-top: auto; /* Push footer to the bottom */

        }

        .content {
            margin-left: 2.5rem;
            margin-right: 2.5rem;
            flex-grow: 1;
        }

        table {
            width: 100%;
            height: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
        }

        tfoot td{
            height: 2rem;
        }

        thead td{
            height: 6rem;
        }
        .prepared{
            width: 100%;
            display: flex;
            justify-content: start;
        }

    </style>
</head>
<body>
    <header>
    <img id="header" src="{{ asset('/images/print/reports/header.png') }}" alt="">
    </header>

        <table style="border:none;">
            <thead style="border:none;">
                <tr style="border:none;">
                    <td style="border:none;"></td>
                </tr>
            </thead>

            <tbody style="border:none;">
                <tr style="border:none;">
                    <td style="border:none;">
                        <div class="content" >
                        <h2>Attendance Report</h2>

                        <table class="table table-bordered">
                        <thead>
                        <tr>
                        <th class="text-end">#</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Card No.</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>College</th>
                        <th>Program</th>
                        <th>Year & Section</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($patrons as $patron)
                            @php
                                $date_object = new DateTime($patron->log_time);
                                $date = $date_object->format('Y-m-d');
                                $time = $date_object->format('h:i A');
                            @endphp
                            <tr>
                            <td class="text-end">{{ $loop->index + 1 }}.</td>
                            <td>{{ $date }}</td>
                            <td>{{ $time }}</td>
                            <td>{{ $patron->card_number }}</td>
                            <td class="text-capitalize">{{ $patron->last_name }}, {{ $patron->first_name }}</td>
                            <td class="text-capitalize">{{ $patron->role }}</td>
                            <td>{{ $patron->college }}</td>
                            <td>{{ $patron->program ?? '--' }}</td>
                            <td>{{ $patron->year }} {{ $patron->section ?? '--' }}</td>
                            </tr>
                        @empty
                            <tr>
                            <td colspan="9" class="text-center">
                                <h1 class="text-center text-muted">No data found.</h1>
                            </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                        <div class="prepared">
                            <p>
                            <b>Prepared By:</b> {{ ucwords(strtolower($prepared_by->first_name)) . ' ' . ucwords(strtolower($prepared_by->middle_name)) . ' ' . ucwords(strtolower($prepared_by->last_name)) }}<br>

                            <b>Role:</b> {{ ucwords(strtolower($prepared_by->role)) }}

                            </p>
                        </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot style="border:none;">
                <tr style="border:none;">
                    <td style="border:none;">
                    </td>
                </tr>
            </tfoot>
        </table>
    <footer>
        <img id="footer" src="{{ asset('/images/print/reports/footer.png') }}" alt="" style="">
    </footer>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
