@component('researches.layout', [
    'researches' => $researches,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/collections">Collections</a></li>
                <li class="breadcrumb-item active" aria-current="page">Research</li>
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
        <form action="/collections/research" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <h4 class="text-body-secondary">Create new research</h4>
            <hr>
            <div class="d-flex column-gap-4">
                <div class="w-100">
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="accession_number" class="form-label">Accession No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="accession_number" id="accession_number" value="{{ old('accession_number') ?? '' }}">
                            @error('accession_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="barcode" class="form-label">Barcode No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="barcode" id="barcode" value="{{ old('barcode') ?? '' }}">
                            @error('barcode')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="call_number" class="form-label">Call No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="call_number" id="call_number" value="{{ old('call_number') ?? '' }}">
                            @error('call_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="date_acquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control form-control-sm" placeholder="--" name="date_acquired" id="date_acquired" value="{{ old('date_acquired') ?? date('Y-m-d') }}">
                            @error('date_acquired')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="title" id="title" value="{{ old('title') ?? '' }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="author" id="author" value="{{ old('author') ?? '' }}">
                        @error('author')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="advisor" class="form-label">Advisor</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="advisor" id="advisor" value="{{ old('advisor') ?? '' }}">
                            @error('advisor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="publisher" id="publisher" value="{{ old('publisher') ?? '' }}">
                            @error('publisher')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                $max_year = (int) date('Y');
                                $min_year = 2000;
                            @endphp
                            <label for="publication_year" class="form-label">Year Submitted</label>
                            <select class="form-control form-control-sm" name="publication_year" id="publication_year">
                                <option value="">--</option>
                                @for($i=$max_year; $i>=$min_year; $i--)
                                    <option {{($i==old('publication_year')) ? 'selected' : '' }}  value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('publication_year')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="number_of_pages" class="form-label">No. of Pages</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="number_of_pages" id="number_of_pages" value="{{ old('number_of_pages') ?? '' }}">
                            @error('number_of_pages')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea style="height: 172px;" class="form-control form-control-sm" placeholder="--" name="summary" id="summary" rows="4">{{ old('summary') ?? '' }}</textarea>
                        @error('summary')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="flex-grow-1 rounded d-flex align-items-center justify-content-center">
                        <div id="research-cover-container" class="border text-center shadow">
                            <img id="research-cover" class="h-100 d-block" src="{{ asset('images/cover_not_available.jpg') }}" alt="">
                        </div>
                        <input class="d-none" type="file" name="file" id="file">
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="tags" class="form-label">Tag(s)</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="tags" id="tags" value="{{ old('tags') ?? '' }}">
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
                                ];
                            @endphp
                            <label for="section" class="form-label">Library Section</label>
                            <select class="form-control form-control-sm text-capitalize" name="section" id="section">
                                <option value="">--</option>
                                @foreach($sections as $section)
                                    <option {{ (old('section')==$section) ? 'selected' : '' }} value="{{ $section }}">{{ $section }} Section</option>
                                @endforeach
                            </select>
                            @error('section')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-control form-control-sm text-capitalize" name="language" id="language">
                                <option value="">--</option>
                                @foreach($languages as $language)
                                    <option {{($language==old('language')) ? 'selected' : '' }} value="{{ $language }}">{{ $language }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="genre" class="form-label">Genre</label>
                            <select class="form-control form-control-sm text-capitalize" name="genre" id="genre">
                                <option value="">--</option>
                                @foreach($genres as $genre)
                                    <option {{($genre==old('genre')) ? 'selected' : '' }} value="{{ $genre }}">{{ $genre }}</option>
                                @endforeach
                            </select>
                            @error('genre')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="doi" class="form-label">DOI</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="doi" id="doi" value="{{ old('doi') ?? '' }}">
                            @error('doi')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                $degrees = ['Bachelor','Master','Doctor'];
                            @endphp
                            <label for="degree" class="form-label">Degree</label>
                            <select class="form-control form-control-sm" name="degree" id="degree">
                                <option value="">--</option>
                                @foreach($degrees as $degree)
                                    <option {{($degree==old('degree')) ? 'selected' : '' }}  value="{{ $degree }}">{{ $degree }}</option>
                                @endforeach
                            </select>
                            @error('degree')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-control form-control-sm text-capitalize" name="format" id="format">
                                <option value="">--</option>
                                @foreach ($formats as $format)
                                    <option {{($format==old('format')) ? 'selected' : '' }}  value="{{ $format }}">{{ $format }}</option>
                                @endforeach
                            </select>
                            @error('format')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-control-sm text-capitalize" name="status" id="status">
                                <option value="">--</option>
                                @foreach ($statuses as $status)
                                    <option {{ $status==old('status') ? 'selected' : '' }} value="{{ $status }}">{{ $status }}</option>
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
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="w-25 btn btn-primary px-3">Submit</button>
            </div>
        </form>
    @endslot
@endcomponent
