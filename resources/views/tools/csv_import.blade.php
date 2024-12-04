<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Tools</a></li>
                    <li class="breadcrumb-item active" aria-current="page">CSV Import</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-upc-scan me-3"></i>CSV Import</h1>
            <hr>
            <div class="d-block mb-4 bg-white">
                <form id="uploadForm" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <input type="file" id="fileInput" accept=".csv" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

                <button id="start-btn" class="btn btn-success" disabled>Start Process</button>

                <table id="table" class="table mt-4 table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.2/papaparse.min.js"></script>
        <script>

            let state = {data: []}
            let header = []

            function loadTable(selector, dataTable) {
                const tableElement = document.querySelector(selector);
                const theadElement = tableElement.querySelector('thead');
                const tbodyElement = tableElement.querySelector('tbody');

                if (!tableElement) {
                    console.error(`Element not found: ${selector}`);
                    return;
                }

                let payload = dataTable
                    .map(
                    (item) => `
                    <th>
                        <p>
                        ${item.title}
                        </p>
                    </th>
                `,
                    )
                    .join('');

                theadElement.innerHTML = `
                    <tr>
                    ${payload}
                    <tr>
                `;

                payload = state.data
                    .map((item) => {
                        const contents = Object.keys(item)
                        .map((key) => {
                            const tdata = dataTable.find((x) => x.id == key);

                            if (tdata) {
                            return tdata.render(item);
                            }
                            return '';
                        })
                        .join('');

                        let action = ``;
                        if (dataTable.some((x) => x.id == 'action')) {
                        action = dataTable[dataTable.length - 1].render(item);
                        }

                        return `
                        <tr>
                        ${contents}
                        ${action}
                        </tr>
                    `;
                    })
                    .join('');

                tbodyElement.innerHTML = payload;
            }

            Object.defineProperty(state, 'data', {
                get() {
                    return this._open;
                },
                set(value) {
                    this._open = value;

                    console.log(value)

                    const headerTable = header.map((x) => {
                        return {
                            id: x,
                            title: x,
                            render: (value) => {
                                return `
                                    <td>
                                    <p>
                                        ${value[x]}
                                    </p>
                                    </td>
                                `
                            }
                        }
                    })

                    headerTable.push({
                            id: 'status',
                            title: 'status',
                            render: (value) => {
                                return `
                                    <td>
                                    <p>
                                        ${value['status']}
                                    </p>
                                    </td>
                                `
                            }
                        })

                    if (value.length > 0) {
                        document.querySelector('#start-btn').removeAttribute('disabled')
                        loadTable(
                            '#table',
                            headerTable
                        )
                    } else {
                        document.querySelector('#start-btn').setAttribute('disabled')
                    }
                },
            });

            document.getElementById('uploadForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const fileInput = document.getElementById('fileInput');
                const file = fileInput.files[0];

                if (!file) {
                    alert('Please select a file!');
                    return;
                }

                Papa.parse(file, {
                    complete: async function (results) {
                        if (results.errors.length > 0) { // incase lang
                            return
                        }

                        header = results.data.slice(0)[0].map((x) => x.trim()) // always get the header and trim
                        const content = results.data.slice(1)

                        let container = content.map((book) => {
                            let data = {}

                            book.map((item, i) => {
                                data[header[i]] = item
                            })

                            return {...data, status:  `<p class='text-primary p-2'>Not started</p>`}
                        }).filter((x) => {
                            let pass = true

                            for (item of header) {
                                if (!Object.keys(x).some((y) => y == item)) {
                                    return false
                                }
                            }

                            return pass
                        })

                        state.data = container

                    },
                    error: function (error) {
                        console.error('Parsing error:', error);
                        alert('Error parsing the file!');
                    },
                });

            });

            async function sendData(index, item) {
                try {
                    const {status, ...data} = item

                    const response = await fetch('/upload-book', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data),
                    });

                    if (!response.ok) throw new Error()

                    state.data = state.data.map((x, i) => {
                        if (i == index) {
                            return {...x, status: `
                                <p class='text-success p-2'>Success po</p>`}
                        }
                        return x
                    })

                    const responseData = await response.json();
                    console.log(response.data)

                } catch (error) {
                    console.error(error);
                    state.data = state.data.map((x, i) => {
                        if (i == index) {
                            return {...x, status: `
                                <button
                                    style="color:red;"
                                    onclick="retry(this)"
                                    data-id="${i}"
                                    class="rounded-sm h-100 w-100"
                                >
                                Retry
                                </button>
                                `}
                        }
                        return x
                    })
                }
            }

            async function retry(button) {
                const id = button.getAttribute('data-id')

                state.data  = state.data.map((x, i) => {
                    if (i == id) {
                        return {...x, status: "Retrying"}
                    }
                    return x
                })

                await sendData(id, state.data[id])
            }

            document.querySelector('#start-btn').onclick = async () => {

                state.data = state.data.map((x) => ({...x, status: `
                    <p class='text-warning p-2'>Pending</p>
                `}))

                const items = state.data

                for (const [index, item] of items.entries()) {
                    await sendData(index, item)
                }
            }
        </script>
    </x-slot:script>
</x-layout>
