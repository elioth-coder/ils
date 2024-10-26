<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-slot:head>
    <x-header />
    <main class="d-flex align-items-center justify-content-center w-100 bg-light">
        <div class="container d-flex py-5">
            <h1>You are in dashboard page</h1>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
        </script>
    </x-slot>
</x-layout>
