<x-layout>
    <x-slot:head>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://unpkg.com/tiny-markdown-editor/dist/tiny-mde.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/tiny-markdown-editor/dist/tiny-mde.min.css" />
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            {{ $breadcrumb ?? '' }}
        </section>

        <div class="container d-flex flex-column pb-5 row-gap-4">
            <section class="w-100">
                <a href="/settings/faqs#faq-form" class="btn btn-outline-success">
                    New FAQ
                    <i class="bi bi-plus"></i>
                </a>
            </section>
            <section class="d-block">
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <section class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                            {{ session('message') }}
                        </section>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table id="faqs-table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Question</th>
                            <th>Keywords</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $faq)
                            <tr>
                                <td style="width: 150px;">
                                    <form id="delete-faq-{{ $faq->id }}"
                                        action="/settings/faqs/{{ $faq->id }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">DELETE</button>
                                    </form>
                                    <a title="Edit" href="/settings/faqs/{{ $faq->id }}/edit#faq-form"
                                        class="btn btn-light btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button title="Delete" onclick="deleteFaq({{ $faq->id }});"
                                        class="btn btn-light btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->keywords }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <section class="d-block">
                <div id="faq-form" class="card p-3 w-full shadow">
                    <div class="card-body">
                        {{ $form ?? '' }}
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            new DataTable('#faqs-table');

            async function deleteFaq(id) {
                let result = await Swal.fire({
                    title: "Delete this faq?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0d6efd",
                    cancelButtonColor: "#bb2d3b",
                    confirmButtonText: "Continue"
                });

                if (result.isConfirmed) {
                    document.querySelector(`#delete-faq-${id} button`).click();
                }
            }

            const tinyMDE = new TinyMDE.Editor({
                textarea: "answer"
            });
            const commandBar = new TinyMDE.CommandBar({
                element: "toolbar",
                editor: tinyMDE,
            });
        </script>
    </x-slot:script>
</x-layout>
