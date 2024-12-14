<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{ $head ?? '' }}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        html,
        body {
            overflow: unset;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    {{ $slot }}
    {{ $script ?? '' }}
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Do you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No!',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Logging out...",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    let response = await fetch('/logout', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });
                    let {
                        status
                    } = await response.json();

                    if (status == 'success') {
                        window.location.reload();
                    } else {
                        Swal.fire({
                            title: 'Failed to logout try again!',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                }
            });
        }
    </script>
</body>

</html>
