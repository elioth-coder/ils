<x-layout>
    <x-header-guest />
    <main class="d-flex flex-column min-vh-100 min-vw-100 bg-success-subtle">
        <div class="container">
            <div class="w-full">
                <h2 class="my-4 text-center">Frequently Asked Questions</h2>
                <form action="/faq" class="my-5 mx-auto d-block" style="width: 700px;">
                    <div class="input-group input-group-lg bg-white rounded-3 shadow">
                        <input value="{{ request('q') ?? '' }}" type="text" name="q" class="form-control" placeholder="Search our FAQ Page">
                        <button class="btn btn-light border" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col mb-5">
                    <div class="card p-5">
                        <div>
                            @foreach ($faqs as $faq)
                                <div class="accordion mb-4" id="accordion-faq-{{ $faq->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-item-{{ $faq->id }}" aria-expanded="true"
                                                aria-controls="collapse-item-{{ $faq->id }}">
                                                <h5 class="fw-bold">{{ $faq->question }}</h5>
                                            </button>
                                        </h2>
                                        <div id="collapse-item-{{ $faq->id }}"
                                            class="accordion-collapse collapse show"
                                            data-bs-parent="#accordion-faq-{{ $faq->id }}">
                                            <div class="accordion-body">{{ $faq->answer }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="">
                            {{ $faqs->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</x-layout>
