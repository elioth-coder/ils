<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable Template</title>
    <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
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
                        <div class="content container d-flex flex-column py-4">
                            <div class="bg-light d-block">
                                <div class="container d-flex flex-column">
                                    <h2 class="text-center">Top List Report</h2>
                                    <div class="d-flex flex-column flex-md-row column-gap-3 row-gap-3 my-4">
                                        <div class="card p-3 d-none d-lg-block w-100">
                                            <div id="most-borrowed-chart" style="height: 300px; width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-3 w-100">
                                <div id="collection-chart" style="height: auto; width: 100%;">
                                    <h5>Most Borrowed Items</h5>
                                    <table id="students-table" class="mt-2 table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Place</th>
                                                <th>Title</th>
                                                <th>Borrowed count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($most_borrowed_books as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{{ $item->borrow_count }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card p-3 w-100">
                                <h5>Top 5 Visitors</h5>
                                <table id="students-table" class="mt-2 table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Place</th>
                                            <th>Name</th>
                                            <th>Total visits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_visitors as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->visit_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card d-block d-lg-none p-3 w-100">
                                <h5>Recently Reported Items</h2>
                                <table id="students-table" style="height: max-content;"
                                    class="mt-2 table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Details</th>
                                            <th>Reported By</th>
                                            <th>Reported On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recent_reported_items as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->details }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ date('m/d/Y h:i A', strtotime($item->created_at)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

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
            CanvasJS.addColorSet("bootstrap5",
                [
                    '#0d6efd',
                    '#198754',
                    '#dc3545',
                    '#ffc107',
                    '#0dcaf0',
                    '#cfe2ff',
                    '#d1e7dd',
                    '#f8d7da',
                    '#fff3cd',
                    '#cff4fc',
                ]);

            const mostborrowedbooks = @json($most_borrowed_books);

            const dataPoints = mostborrowedbooks.sort((a, b) => a.borrow_count - b.borrow_count).map((book, i) => {
                return {
                    label: book.title,
                    y: book.borrow_count
                }
            });

            var borrowedRankChart = new CanvasJS.Chart("most-borrowed-chart", {
                exportEnabled: true,
                animationEnabled: true,
                colorSet: 'bootstrap5',
                title: {
                    text: "Most Borrowed items"
                },
                axisX: {
                    margin: 10,
                    tickPlacement: "inside"
                },
                axisY2: {
                    title: "Borrowed",
                    titleFontSize: 14,
                    interval: Math.ceil(dataPoints[0].y / 2) || 1
                },
                data: [{
                    type: "bar",
                    dataPoints: dataPoints
                }]
            });
            borrowedRankChart.render();

            var collectionChart = new CanvasJS.Chart("collection-chart", {
                animationEnabled: true,
                colorSet: 'bootstrap5',
                title: {
                    text: "Number of Collections per Type"
                },
                axisY: {
                    title: "Collection Count"
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Type of Collections",
                    dataPoints: collectionDataPoints,
                }]
            });
            collectionChart.render();

            window.print();
        }
    </script>

</body>
</html>
