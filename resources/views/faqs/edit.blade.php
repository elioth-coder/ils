@component('faqs.layout', [
    'faqs' => $faqs,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQs</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/faqs/{{ $selected->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <h4 class="text-body-secondary">Edit this FAQ</h4>
            <hr>
            <div class="d-flex">
                <div class="w-100">
                    <div class="mb-2">
                        <div class="w-50">
                            @php
                                if ($errors->has('question')) {
                                    $question = old('question');
                                } else {
                                    $question = old('question') ? old('question') : $selected->question;
                                }
                            @endphp
                            <label for="question" class="form-label">Question</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="question"
                                id="question" value="{{ $question }}">
                            @error('question')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('answer')) {
                                $answer = old('answer');
                            } else {
                                $answer = old('answer') ? old('answer') : $selected->answer;
                            }
                        @endphp
                        <label for="answer" class="form-label">Answer</label>
                        <div class="border rounded">
                            <div class="rounded" id="toolbar"></div>
                            <textarea style="height: 172px;" class="rounded form-control form-control-sm" placeholder="--" name="answer" id="answer" rows="4">{{ $answer }}</textarea>
                            @error('answer')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @php
                            if ($errors->has('keywords')) {
                                $keywords = old('keywords');
                            } else {
                                $keywords = old('keywords') ? old('keywords') : $selected->keywords;
                            }
                        @endphp
                        <label for="keywords" class="form-label">Keywords</label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="keywords"
                            id="keywords" value="{{ $keywords }}">
                        @error('keywords')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2 flex-row-reverse">
                <a href="/settings/faqs" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                <button type="submit" class="w-25 btn btn-primary px-3">Update</button>
            </div>
        </form>
    @endslot
@endcomponent
