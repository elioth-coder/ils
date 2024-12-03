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
                    <li class="breadcrumb-item active" aria-current="page">DB Backup-Restore</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-database-check me-3"></i>DB Backup-Restore</h1>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" onclick="confirmGenerate();">Generate Backup</button>
            </div>
            <div class="my-3">
                @if (session('error'))
                    <div class="alert alert-error alert-dismissible fade show" role="alert">
                        <section class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                            {{ session('error') }}
                        </section>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <section class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                            {{ session('success') }}
                        </section>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">File Name</th>
                        <th scope="col">Size</th>
                        <th scope="col">Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="px-6 py-4 border-b">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 border-b">{{ $file['name'] }}</td>
                            <td class="px-6 py-4 border-b">{{ $file['size'] }}</td>
                            <td class="px-6 py-4 border-b">{{ $file['modified'] }}</td>
                            <td class="px-6 py-4 border-b gap-2 text-center">
                                <button onclick="confirmDelete('{{ $file['name'] }}');" class="btn btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button onclick="confirmRestore('{{ $file['name'] }}');" class="btn btn-success">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <h1>Restore from file</h1>
            <form action="/backup_db/restore_from_file" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="data">
                    <input type="file" id="data" name="database" accept='.sql'>
                    <button type="submit" class="btn btn-primary">Restore</button>
                </label>
            </form>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            function generateBackup() {
                Swal.fire({
                    title: "Generating backup...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    let response = await fetch('/tools/backup_db/generate', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    let {
                        status,
                        message
                    } = await response.json();

                    await Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    if (status == 'success') {
                        window.location.reload();
                    }
                });
            }

            function deleteBackup(file_name) {
                Swal.fire({
                    title: "Deleting backup...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('file_name', file_name);

                    console.log(formData.get('file_name'))
                    let response = await fetch('/tools/backup_db/delete', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    let {
                        status,
                        message
                    } = await response.json();

                    await Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    if (status == 'success') {
                        window.location.reload();
                    }
                });
            }

            function restoreDatabase(file_name) {
                Swal.fire({
                    title: "Restoring database...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('file_name', file_name);

                    console.log(formData.get('file_name'))
                    let response = await fetch('/tools/backup_db/restore', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    let {
                        status,
                        message
                    } = await response.json();

                    await Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    if (status == 'success') {
                        window.location.reload();
                    }
                });
            }

            function confirmGenerate() {
                Swal.fire({
                    title: 'Generate database backup?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        generateBackup();
                    }
                });
            }

            function confirmDelete(file_name) {
                Swal.fire({
                    title: 'Delete this backup file?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteBackup(file_name);
                    }
                });
            }

            function confirmRestore(file_name) {
                Swal.fire({
                    title: 'Restore database from this file?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        restoreDatabase(file_name);
                    }
                });
            }
        </script>
    </x-slot:script>
</x-layout>
