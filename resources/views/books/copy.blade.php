@component('books.layout', [
    'books' => $books,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/collections">Collections</a></li>
                <li class="breadcrumb-item"><a href="/collections/books">Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->id }}</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <style>
            #book-cover-container {
                width: 235px;
                height: 350px;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                position: relative;
            }

            #book-cover-container img {
                height: 100%;
                width: auto;
                object-fit: cover;
                position: absolute;
            }
        </style>
        <form action="/collections/books/{{ $selected->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h4 class="text-body-secondary">Create copy of book</h4>
            <hr>
            <div class="d-flex column-gap-4">
                <div class="w-100">
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('accession_number')) {
                                    $accession_number = old('accession_number');
                                } else {
                                    $accession_number = old('accession_number')
                                        ? old('accession_number')
                                        : $selected->accession_number;
                                }
                            @endphp
                            <label for="accession_number" class="form-label">Accession No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="accession_number"
                                id="accession_number" value="{{ $accession_number }}">
                            @error('accession_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('barcode_number')) {
                                    $barcode_number = old('barcode_number');
                                } else {
                                    $barcode_number = old('barcode_number')
                                        ? old('barcode_number')
                                        : $selected->barcode_number;
                                }
                            @endphp
                            <label for="barcode_number" class="form-label">Barcode No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="barcode_number"
                                id="barcode_number" value="{{ $barcode_number }}">
                            @error('barcode_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('lcc_number')) {
                                    $lcc_number = old('lcc_number');
                                } else {
                                    $lcc_number = old('lcc_number') ? old('lcc_number') : $selected->lcc_number;
                                }
                            @endphp
                            <label for="lcc_number" class="form-label">LCC No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="lcc_number"
                                id="lcc_number" value="{{ $lcc_number }}">
                            @error('lcc_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('ddc_number')) {
                                    $ddc_number = old('ddc_number');
                                } else {
                                    $ddc_number = old('ddc_number') ? old('ddc_number') : $selected->ddc_number;
                                }
                            @endphp
                            <label for="ddc_number" class="form-label">DDC No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="ddc_number"
                                id="ddc_number" value="{{ $ddc_number }}">
                            @error('ddc_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('isbn')) {
                                $isbn = old('isbn');
                            } else {
                                $isbn = old('isbn') ? old('isbn') : $selected->isbn;
                            }
                        @endphp
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="isbn"
                            id="isbn" value="{{ $isbn }}">
                        @error('isbn')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('title')) {
                                $title = old('title');
                            } else {
                                $title = old('title') ? old('title') : $selected->title;
                            }
                        @endphp
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="title"
                            id="title" value="{{ $title }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('author')) {
                                $author = old('author');
                            } else {
                                $author = old('author') ? old('author') : $selected->author;
                            }
                        @endphp
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="author"
                            id="author" value="{{ $author }}">
                        @error('author')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('publisher')) {
                                    $publisher = old('publisher');
                                } else {
                                    $publisher = old('publisher') ? old('publisher') : $selected->publisher;
                                }
                            @endphp
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="publisher"
                                id="publisher" value="{{ $publisher }}">
                            @error('publisher')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('publication_year')) {
                                    $publication_year = old('publication_year');
                                } else {
                                    $publication_year = old('publication_year')
                                        ? old('publication_year')
                                        : $selected->publication_year;
                                }

                                $max_year = (int) date('Y');
                                $min_year = 1500;
                            @endphp
                            <label for="publication_year" class="form-label">Publication Year</label>
                            <select class="form-control form-control-sm" name="publication_year" id="publication_year">
                                <option value="">--</option>
                                @for ($i = $max_year; $i >= $min_year; $i--)
                                    <option {{ $publication_year == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            @error('publication_year')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('number_of_pages')) {
                                    $number_of_pages = old('number_of_pages');
                                } else {
                                    $number_of_pages = old('number_of_pages')
                                        ? old('number_of_pages')
                                        : $selected->number_of_pages;
                                }
                            @endphp
                            <label for="number_of_pages" class="form-label">No. of Pages</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--"
                                name="number_of_pages" id="number_of_pages" value="{{ $number_of_pages }}">
                            @error('number_of_pages')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('price')) {
                                    $price = old('price');
                                } else {
                                    $price = old('price') ? old('price') : $selected->price;
                                }
                            @endphp
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="price"
                                id="price" value="{{ $price }}">
                            @error('price')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('summary')) {
                                $summary = old('summary');
                            } else {
                                $summary = old('summary') ? old('summary') : $selected->summary;
                            }
                        @endphp
                        <label for="summary" class="form-label">Summary</label>
                        <textarea style="height: 172px;" class="form-control form-control-sm" placeholder="--" name="summary"
                            id="summary" rows="4">{{ $summary }}</textarea>
                        @error('summary')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="flex-grow-1 rounded d-flex align-items-center justify-content-center">
                        <div id="book-cover-container" class="border text-center shadow">
                            @php $book_cover = ($selected->cover_image) ? "/storage/images/books/$selected->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                            <img id="book-cover" class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                        </div>
                        <input class="d-none" type="file" name="file" id="file">
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('tags')) {
                                $tags = old('tags');
                            } else {
                                $tags = old('tags') ? old('tags') : $selected->tags;
                            }
                        @endphp
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="tags"
                            id="tags" value="{{ $tags }}">
                        @error('tags')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('language')) {
                                    $language = old('language');
                                } else {
                                    $language = old('language') ? old('language') : $selected->language;
                                }
                            @endphp
                            <label for="language" class="form-label">Language</label>
                            <select class="form-control form-control-sm text-capitalize" name="language" id="language">
                                <option value="">--</option>
                                @foreach ($languages as $_language)
                                    <option {{ $_language == $language ? 'selected' : '' }} value="{{ $_language }}">
                                        {{ $_language }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('genre')) {
                                    $genre = old('genre');
                                } else {
                                    $genre = old('genre') ? old('genre') : $selected->genre;
                                }
                            @endphp
                            <label for="genre" class="form-label">Genre</label>
                            <select class="form-control form-control-sm text-capitalize" name="genre" id="genre">
                                <option value="">--</option>
                                @foreach ($genres as $_genre)
                                    <option {{ $_genre == $genre ? 'selected' : '' }} value="{{ $_genre }}">
                                        {{ $_genre }}</option>
                                @endforeach
                            </select>
                            @error('genre')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('format')) {
                                    $format = old('format');
                                } else {
                                    $format = old('format') ? old('format') : $selected->format;
                                }
                            @endphp
                            <label for="format" class="form-label">Format</label>
                            <select class="form-control form-control-sm text-capitalize" name="format" id="format">
                                <option value="">--</option>
                                @foreach ($formats as $_format)
                                    <option {{ $_format == $format ? 'selected' : '' }} value="{{ $_format }}">
                                        {{ $_format }}</option>
                                @endforeach
                            </select>
                            @error('format')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('status')) {
                                    $status = old('status');
                                } else {
                                    $status = old('status') ? old('status') : $selected->status;
                                }
                            @endphp
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-control-sm text-capitalize" name="status" id="status">
                                <option value="">--</option>
                                @foreach ($statuses as $_status)
                                    <option {{ $_status == $status ? 'selected' : '' }} value="{{ $_status }}">
                                        {{ $_status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2 flex-row-reverse">
                <a href="/collections/books" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                <button type="submit" class="w-25 btn btn-primary px-3">Submit</button>
            </div>
        </form>
    @endslot
@endcomponent
