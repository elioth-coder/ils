@use('Illuminate\Support\Str')

<x-layout>
    <x-header-guest />
    <main class="d-flex flex-column min-vh-100 min-vw-100 bg-success-subtle">
        <div class="container">
            <div class="w-full">
                <h2 class="my-4 text-center">Frequently Asked Questions</h2>
            </div>
            <div class="row">
                <div class="col-6 mb-5">
                    <form action="/faq" class="mx-auto d-block w-full">
                        <div class="input-group input-group-lg bg-white rounded-3 shadow">
                            <input value="{{ request('q') ?? '' }}" type="text" name="q" class="form-control" placeholder="Search our FAQ Page">
                            <button class="btn btn-light border" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="py-1">
                        <img src="{{ asset('images/faq-cartoon.png') }}" class="w-full" alt="">
                    </div>
                </div>
                <div class="col-6 mb-5">
                    <div class="card p-5 pt-4">
                        @if(!empty(request('q')))
                            <h5 class="mt-0 mb-4">Search results for: <span class="text-primary">{{ request('q') }}</span></h5>
                        @endif

                        <div>
                            @foreach ($faqs as $faq)
                                <div class="accordion mb-2" id="accordion-faq-{{ $faq->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed bg-success-subtle" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-item-{{ $faq->id }}" aria-expanded="true"
                                                aria-controls="collapse-item-{{ $faq->id }}">
                                                <h6 class="fw-bold">{{ $faq->question }}</h6>
                                            </button>
                                        </h2>
                                        <div id="collapse-item-{{ $faq->id }}"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#accordion-faq-{{ $faq->id }}">
                                            <div class="accordion-body">
                                                {!! Str::markdown($faq->answer) !!}
                                            </div>
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
