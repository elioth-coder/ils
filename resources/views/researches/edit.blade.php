@component('researches.layout', [
    'researches' => $researches,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/collections">Collections</a></li>
                <li class="breadcrumb-item"><a href="/collections/research">Research</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->id }}</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <style>
        #research-cover-container {
          width: 235px;
          height: 350px;
          display: flex;
          justify-content: center;
          align-items: center;
          overflow: hidden;
          position: relative;
        }

        #research-cover-container img {
          height: 100%;
          width: auto;
          object-fit: cover;
          position: absolute;
        }
        </style>
        <form action="/collections/research/{{ $selected->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <h4 class="text-body-secondary">Edit this research</h4>
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
                                if ($errors->has('barcode')) {
                                    $barcode = old('barcode');
                                } else {
                                    $barcode = old('barcode')
                                        ? old('barcode')
                                        : $selected->barcode;
                                }
                            @endphp
                            <label for="barcode" class="form-label">Barcode No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="barcode"
                                id="barcode" value="{{ $barcode }}">
                            @error('barcode')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('call_number')) {
                                    $call_number = old('call_number');
                                } else {
                                    $call_number = old('call_number') ? old('call_number') : $selected->call_number;
                                }
                            @endphp
                            <label for="call_number" class="form-label">Call No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="call_number"
                                id="call_number" value="{{ $call_number }}">
                            @error('call_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('date_acquired')) {
                                    $date_acquired = old('date_acquired');
                                } else {
                                    $date_acquired = (old('date_acquired')) ? old('date_acquired') : $selected->date_acquired;
                                }
                            @endphp
                            <label for="date_acquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control form-control-sm" placeholder="--" name="date_acquired" id="date_acquired" value="{{ $date_acquired }}">
                            @error('date_acquired')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
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
                                if ($errors->has('advisor')) {
                                    $advisor = old('advisor');
                                } else {
                                    $advisor = old('advisor') ? old('advisor') : $selected->advisor;
                                }
                            @endphp
                            <label for="advisor" class="form-label">Advisor</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="advisor" id="advisor" value="{{ $advisor }}">
                            @error('advisor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if ($errors->has('number_of_pages')) {
                                    $number_of_pages = old('number_of_pages');
                                } else {
                                    $number_of_pages = old('number_of_pages') ? old('number_of_pages') : $selected->number_of_pages;
                                }
                            @endphp
                            <label for="number_of_pages" class="form-label">No. of Pages</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="number_of_pages" id="number_of_pages" value="{{ $number_of_pages }}">
                            @error('number_of_pages')
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
                        <div id="research-cover-container" class="border text-center shadow">
                            @php $research_cover = ($selected->cover_image) ? "/storage/images/$selected->type/$selected->cover_image" : '/images/cover_not_available.jpg'; @endphp
                            <img id="research-cover" class="h-100 d-block" src="{{ asset($research_cover) }}" alt="">
                        </div>
                        <input class="d-none" type="file" name="file" id="file">
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
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
                        <div class="mb-2 w-100">
                            @php
                                $sections = [
                                    'circulation',
                                    'filipiniana',
                                    'periodical',
                                    'reference',
                                    'e-library',
                                    'audio-visual',
                                    'thesis',
                                ];

                                if ($errors->has('section')) {
                                    $section = old('section');
                                } else {
                                    $section = old('section') ? old('section') : $selected->section;
                                }
                            @endphp

                            <label for="section" class="form-label">Library Section</label>
                            <select class="form-control form-control-sm text-capitalize" name="section" id="section">
                                <option value="">--</option>
                                @foreach($sections as $_section)
                                    <option {{ $_section == $section ? 'selected' : '' }}  value="{{ $_section }}">{{ $_section }} Section</option>
                                @endforeach
                            </select>
                            @error('section')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
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
                                if ($errors->has('doi')) {
                                    $doi = old('doi');
                                } else {
                                    $doi = old('doi')
                                        ? old('doi')
                                        : $selected->doi;
                                }
                            @endphp
                            <label for="doi" class="form-label">DOI</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="doi"
                                id="doi" value="{{ $doi }}">
                            @error('doi')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                $degrees = ['Bachelor','Master','Doctor'];
                                if ($errors->has('degree')) {
                                    $degree = old('degree');
                                } else {
                                    $degree = old('degree') ? old('degree') : $selected->degree;
                                }
                            @endphp
                            <label for="degree" class="form-label">Degree</label>
                            <select class="form-control form-control-sm" name="degree" id="degree">
                                <option value="">--</option>
                                @foreach($degrees as $_degree)
                                    <option {{ $_degree == $degree ? 'selected' : '' }}  value="{{ $_degree }}">{{ $_degree }}</option>
                                @endforeach
                            </select>
                            @error('degree')
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
                <a href="{{ url()->previous() }}" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                <button type="submit" class="w-25 btn btn-primary px-3">Update</button>
            </div>
        </form>
    @endslot
@endcomponent
