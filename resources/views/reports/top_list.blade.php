<x-layout>
    <x-slot:head>
        <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
    </x-slot>
    <x-header />
    <main class="d-flex align-patrons-center justify-content-center w-100 bg-light">
        <div class="container d-flex flex-column py-4">
            <div class="bg-light d-none d-lg-block">
                <div class="container d-flex flex-column">
                    <h2 class="text-center">Top List Report</h2>
                    <div class="d-flex flex-column flex-md-row column-gap-3 row-gap-3 my-4">
                        <div class="card p-3 d-none d-lg-block w-100">
                            <div id="most-borrowed-chart" style="height: 300px; width: 100%;"></div>
                        </div>

                        <div class="card d-block d-lg-none p-3 w-100">
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
                            <div id="collection-chart" style="height: 300px; width: 100%;">
                                <h5>Top 5 Visitors</h5>
                                <table id="students-table" class="mt-2 table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Place</th>
                                            <th>Name</th>
                                            <th class="text-center">Total visits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_visitors as $index => $user)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ strtoupper($user->name) }}</td>
                                                <td class="text-center">{{ $user->visit_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4">List of Reported Items</h4>
                    <table id="students-table" style="height: max-content;"
                        class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Document Title</th>
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
                                    <td>{{ date('m/d/Y h:i A', strtotime($item->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <table class="d-table d-lg-none">
                <thead>
                    <tr>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h1 style="text-align: center; margin-top: 20px;">Quick Library Reports</h1>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex flex-column flex-md-row column-gap-3 row-gap-3 m-4">
                                <div class="card p-3 d-none d-lg-block w-100">
                                    <div id="most-borrowed-chart" style="height: 300px; width: 100%;"></div>
                                </div>

                                <div class="card d-block d-lg-none p-3 w-100">
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
                                    <div id="collection-chart" style="height: 300px; width: 100%;">
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
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex flex-column flex-md-row column-gap-3 row-gap-3 m-4">
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

                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>
    <div class="d-flex justify-content-end pe-5 w-100 mb-3">
        <div class="d-flex justify-content-end pe-5 w-75 mb-3">
            <button id="printButton" class="btn btn-primary">Print</button>
        </div>

        <script>
            document.getElementById('printButton').addEventListener('click', () => {
                window.location.href = `/reports/top_list/print?_method=GET`;
            });
        </script>
    </div>
    <x-footer />
    <x-slot:script>
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
            }
        </script>
    </x-slot>
</x-layout>
