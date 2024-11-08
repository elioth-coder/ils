<div class="container py-4">
    @php
    $path = request()->path();
    $segments = explode('/', $path);
    $type = $segments[1] ?? '';
    @endphp
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $type=='' ? 'active' : ''}}" aria-current="page" href="/search">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type=='book' ? 'active' : ''}}" href="/search/book">Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type=='research' ? 'active' : ''}}" href="/search/research">Research</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type=='audio' ? 'active' : ''}}" href="/search/audio">Audio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type=='video' ? 'active' : ''}}" href="/search/video">Video</a>
        </li>
    </ul>
    <form action="/search">
        @if(request('tags'))
            <input type="hidden" name="tags" value="{{ request('tags') ?? '' }}">
        @endif
        @if(request('publisher'))
            <input type="hidden" name="publisher" value="{{ request('publisher') ?? '' }}">
        @endif
        @if(request('genre'))
            <input type="hidden" name="genre" value="{{ request('genre') ?? '' }}">
        @endif
        @if(request('format'))
            <input type="hidden" name="format" value="{{ request('format') ?? '' }}">
        @endif
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') ?? '' }}">
        @endif
        <div class="input-group mb-3">
            <input type="text" name="q" value="{{ request('q') ?? '' }}" class="form-control"
                placeholder="Search">
            <button type="submit" class="btn btn-primary" type="button" id="button-addon2">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="w-50">
                <b>{{ $totalItems }} results</b>
            </div>
            <div class="w-50 d-flex flex-row-reverse gap-2">
                <div x-data="{
                        limit: {{ request('limit') ?? 5 }},
                        options: [5,10,15,20,50]
                    }" class="dropdown border rounded">
                    <input type="hidden" name="limit" x-bind:value="limit">
                    <button class="btn dropdown-toggle bg-light"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        x-text="limit">

                    </button>
                    <ul class="dropdown-menu">
                        <template x-for="option in options">
                            <li><a class="dropdown-item"
                                href="#"
                                x-on:click.prevent="limit=option"
                                x-text="option"></a>
                            </li>
                        </template>
                    </ul>
                </div>
                <div x-data="{
                        sort_by: '{{ request('sort_by') ?? 'title' }}',
                        options: {
                            title: 'Title',
                            publisher: 'Publisher',
                            publication_year: 'Year',
                        }
                    }" class="dropdown border rounded">
                    <input type="hidden" name="sort_by" x-bind:value="sort_by">
                    <button class="btn dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Sort by: <span class="text-capitalize" x-text="options[sort_by]"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <template x-for="key in Object.keys(options)">
                            <li>
                                <a x-on:click.prevent="sort_by = key; label = options[key]"
                                    href="#"
                                    class="dropdown-item text-capitalize"
                                    x-text="options[key]"></a>
                            </li>
                        </template>
                    </ul>
                </div>
                @php
                $order = request('order') ?? 'ASC';
                @endphp
                <div x-data="{ order: '{{ $order }}' }">
                    <input type="hidden" name="order" x-bind:value="order">
                    <button type="button" x-on:click="order = (order=='DESC') ? 'ASC' : 'DESC'" class="btn btn-outline-secondary border">
                        <template x-if="order=='ASC'">
                            <i title="Ascending" class="bi bi-sort-up"></i>
                        </template>
                        <template x-if="order=='DESC'">
                            <i title="Descending" class="bi bi-sort-down"></i>
                        </template>
                    </button>
                </div>
                <a href="/collections/book#book-form" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Add
                </a>
            </div>
        </div>
    </form>
</div>
