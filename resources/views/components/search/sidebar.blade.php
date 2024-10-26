<div style="min-width: 300px;">
    <div class="accordion mb-2" id="accordion-library">
        <div class="accordion-item">
            @php
                $keys   = array_column($filters, 0);
                $values = array_column($filters, 1);
                $is_filtered = in_array('library', $keys);
            @endphp
            <h2 class="accordion-header">
                <button class="accordion-button {{ ($is_filtered) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-library" aria-expanded="{{ ($is_filtered) ? 'true' : 'false' }}" aria-controls="collapse-library">
                    Library
                </button>
            </h2>
            <div id="collapse-library" class="accordion-collapse collapse {{ ($is_filtered) ? 'show' : '' }}"
                data-bs-parent="#accordion-library">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($libraries as $library)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $library->code }}" onchange="addFilter(this, 'library');"
                                @if(in_array($library->code, $values)) checked @endif
                                id="{{ strtolower($library->code) }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="{{ strtolower($library->code) }}">
                                {{ $library->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="accordion mb-2" id="accordion-publisher">
        <div class="accordion-item">
            @php
                $qsPublisher = request('publisher');
                $csPublishers = explode(',', $qsPublisher);
            @endphp
            <h2 class="accordion-header">
                <button class="accordion-button {{ ($qsPublisher) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-publisher" aria-expanded="{{ ($qsPublisher) ? 'true' : 'false' }}" aria-controls="collapse-publisher">
                    Publisher
                </button>
            </h2>
            <div id="collapse-publisher" class="accordion-collapse collapse {{ ($qsPublisher) ? 'show' : '' }}"
                data-bs-parent="#accordion-publisher">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($publishers as $publisher)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $publisher }}" onchange="addFilter(this, 'publisher');"
                                @if(in_array($publisher, $csPublishers)) checked @endif
                                id="publisher-{{ $loop->index }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="publisher-{{ $loop->index }}">
                                {{ $publisher }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="accordion mb-2" id="accordion-publication_year">
        <div class="accordion-item">
            @php
                $year  = request('year');
                $years = explode('-', $year);
                $max_year = (int) date('Y');
                $min_year = 1500;
                $from = ($year) ? $years[0] : '';
                $to   = ($year) ? $years[1] : '';
                $is_filtered = ($year) ? true : false;
            @endphp
            <h2 class="accordion-header">
                <button class="accordion-button {{ ($is_filtered) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-publication_year" aria-expanded="{{ ($is_filtered) ? 'true' : 'false' }}" aria-controls="collapse-publication_year">
                    Publication Year
                </button>
            </h2>
            <div id="collapse-publication_year" class="accordion-collapse collapse  {{ ($is_filtered) ? 'show' : '' }}"
                data-bs-parent="#accordion-publication_year">
                <div class="accordion-body text-end">
                    <div class="input-group mb-3">
                        <select id="from" name="from" class="form-control form-control-sm">
                            <option value="">-- From --</option>
                            @for($i=$max_year; $i>=$min_year; $i--)
                                <option {{ ($from==$i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <span class="input-group-text">-</span>
                        <select id="to" name="to" class="form-control form-control-sm">
                            <option value="">-- To --</option>
                            @for($i=$max_year; $i>=$min_year; $i--)
                                <option {{ ($to==$i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button onclick="applyYearFilter()" class="btn btn-outline-primary btn-sm">Apply</button>
                    <button onclick="clearYearFilter()" class="btn btn-outline-primary btn-sm">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion mb-2" id="accordion-genre">
        <div class="accordion-item">
            @php
                $qsGenre = request('genre');
                $csGenres = explode(',', $qsGenre);
            @endphp
            <h2 class="accordion-header">
                <button class="accordion-button {{ ($qsGenre) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-genre" aria-expanded="{{ ($qsGenre) ? 'true' : 'false' }}" aria-controls="collapse-genre">
                    Genre
                </button>
            </h2>
            <div id="collapse-genre" class="accordion-collapse collapse {{ ($qsGenre) ? 'show' : '' }}"
                data-bs-parent="#accordion-genre">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($genres as $genre)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $genre }}" onchange="addFilter(this, 'genre');"
                                @if(in_array($genre, $csGenres)) checked @endif
                                id="genre-{{ $loop->index }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="genre-{{ $loop->index }}">
                                {{ $genre }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="accordion mb-2" id="accordion-format">
        <div class="accordion-item">
            @php
                $qsFormat = request('format');
                $csFormats = explode(',', $qsFormat);
            @endphp

            <h2 class="accordion-header">
                <button class="accordion-button {{ ($qsFormat) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-format" aria-expanded="{{ ($qsFormat) ? 'true' : 'false' }}" aria-controls="collapse-format">
                    Format
                </button>
            </h2>
            <div id="collapse-format" class="accordion-collapse collapse {{ ($qsFormat) ? 'show' : '' }}"
                data-bs-parent="#accordion-format">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($formats as $format)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $format }}" onchange="addFilter(this, 'format');"
                                @if(in_array($format, $csFormats)) checked @endif
                                id="format-{{ $loop->index }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="format-{{ $loop->index }}">
                                {{ $format }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="accordion mb-2" id="accordion-status">
        <div class="accordion-item">
            @php
                $qsStatus = request('status');
                $csStatuses = explode(',', $qsStatus);
            @endphp

            <h2 class="accordion-header">
                <button class="accordion-button {{ ($qsStatus) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-status" aria-expanded="{{ ($qsStatus) ? 'true' : 'false' }}" aria-controls="collapse-status">
                    Status
                </button>
            </h2>
            <div id="collapse-status" class="accordion-collapse collapse {{ ($qsStatus) ? 'show' : '' }}"
                data-bs-parent="#accordion-status">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($statuses as $status)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $status }}" onchange="addFilter(this, 'status');"
                                @if(in_array($status, $csStatuses)) checked @endif
                                id="status-{{ $loop->index }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="status-{{ $loop->index }}">
                                {{ $status }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}


    <div class="accordion mb-2" id="accordion-tag">
        <div class="accordion-item">
            @php
                $qsTag = request('tag');
                $csTags = explode(',', $qsTag);
            @endphp

            <h2 class="accordion-header">
                <button class="accordion-button {{ ($qsTag) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-tag" aria-expanded="{{ ($qsTag) ? 'true' : 'false' }}" aria-controls="collapse-tag">
                    Tags
                </button>
            </h2>
            <div id="collapse-tag" class="accordion-collapse collapse {{ ($qsTag) ? 'show' : '' }}"
                data-bs-parent="#accordion-tag">
                <div class="accordion-body overflow-y-auto" style="max-height: 250px;">
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $tag }}" onchange="addFilter(this, 'tag');"
                                @if(in_array($tag, $csTags)) checked @endif
                                id="tag-{{ $loop->index }}">
                            <label style="cursor: pointer; font-size: 14px;" class="form-check-label" for="tag-{{ $loop->index }}">
                                {{ $tag }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
