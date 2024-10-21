<div class="container py-4">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active bg-transparent" aria-current="page" href="/search/books">Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/search/researches">Thesis/Research</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/search/media_discs">Media Discs</a>
        </li>
    </ul>
    <form action="/search">
        <input type="hidden" name="publisher" value="{{ request('publisher') ?? '' }}">
        <input type="hidden" name="genre" value="{{ request('genre') ?? '' }}">
        <input type="hidden" name="format" value="{{ request('format') ?? '' }}">
        <input type="hidden" name="status" value="{{ request('status') ?? '' }}">
        <div class="input-group mb-3">
            <input type="text" name="q" value="{{ request('q') ?? '' }}" class="form-control"
                placeholder="Search">
            <button type="submit" class="btn btn-primary" type="button" id="button-addon2">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="w-50">
                <b>{{ count($books) }} results</b>
            </div>
            <div class="w-50 d-flex flex-row-reverse gap-2">
                <div class="dropdown">
                    <button class="btn dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        10
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">10</a></li>
                        <li><a class="dropdown-item" href="#">20</a></li>
                        <li><a class="dropdown-item" href="#">50</a></li>
                        <li><a class="dropdown-item" href="#">100</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Sort by: Title
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Date (newest)</a></li>
                        <li><a class="dropdown-item" href="#">Date (oldest)</a></li>
                        <li><a class="dropdown-item" href="#">Relevance</a></li>
                    </ul>
                </div>
                <a href="/collections/books#books-form" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Add
                </a>
            </div>
        </div>
    </form>
</div>
