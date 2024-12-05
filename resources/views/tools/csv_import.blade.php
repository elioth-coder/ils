<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.2/papaparse.min.js"></script>
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
            <h1 class="text-center"><i class="bi bi-filetype-csv me-3"></i>CSV Import</h1>
            <hr>

            <div class="my-4 bg-white p-3 border rounded shadow">
                <div class="mb-3">
                    <input type="file" id="input-file" accept=".csv" class="form-control" />
                </div>

                <div class="w-100 p-3" id="table-container"></div>
                <button onclick="startImport();" class="btn btn-primary">
                    Start Import
                </button>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            let items = [];

            async function startImport() {
                for(let i=0; i<items.length; i++) {
                    await uploadItem(i);
                }

                await Swal.fire({
                    title: "Successfully imported all items",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000,
                }).then(() => {
                    window.location.reload();
                });
            }

            function parseFile(file) {
                return new Promise((resolve, reject) => {
                    Papa.parse(file, {
                        header: true,
                        skipEmptyLines: true,
                        complete: function(results) {
                            resolve(results.data);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            resolve([]);
                        },
                    });
                })
            }

            async function uploadItem(index) {
                let $td = document.querySelector(`#status_${index}`);
                let item = items[index];

                $td.innerHTML = `<span>Uploading...</span>`;
                let formData = new FormData();

                let keys = Object.keys(item);
                keys.forEach(key => {
                    formData.set(key, item[key]);
                });

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let response = await fetch('/tools/process_csv_import', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });

                let { status, message } = await response.json();

                if(status == 'success') {
                    $td.innerHTML = `<span class="text-success">
                        <i class="bi bi-check-lg"></i>
                        Success
                    </span>`;
                }
            }

            window.onload = function() {
                document.getElementById('input-file').addEventListener('change', async function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        items = await parseFile(file);

                        let $container = document.querySelector('#table-container')
                        let row_1 = items[0];

                        let keys = Object.keys(row_1);
                        let theadCells = '';
                        let tbodyRows = '';

                        keys.forEach(key => {
                            theadCells += `<th>${key}</th>`;
                        });
                        theadCells += `<th>status</th>`;

                        items.forEach((item, index) => {
                            let rowCells = '';
                            let row = '';

                            keys.forEach(key => {
                                rowCells += `<td>${item[key]}</td>`;
                            });
                            rowCells += `<td id="status_${index}">
                                <button onclick="uploadItem(${index});" class="btn btn-outline-dark">Upload</button>
                            </td>`;

                            tbodyRows += `<tr>${rowCells}</tr>`;
                        });

                        let tableHtml = `
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>${theadCells}</tr>
                                </thead>
                                <tbody>${tbodyRows}</tbody>
                            </table>
                        `;

                        $container.innerHTML = tableHtml;
                    }
                });
            }
        </script>
    </x-slot:script>
</x-layout>
