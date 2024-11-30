@props(['items' => []])
<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="2" class="text-center">
                <h4>Top Collections</h4>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td class="text-center">
                    <section style="height: 110px;" class="card p-1 mx-auto position-relative">
                        @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                        <object class="h-100 d-block" data="{{ asset($item_cover) }}" type="image/png">
                            <img class="h-100 d-block" src="/images/cover_not_available.jpg" alt="">
                        </object>
                        <h5 style="width: 30px;" class="mb-1 me-1 d-block position-absolute top-0 z-10 bg-white">
                            #{{ $loop->index + 1 }}
                        </h5>
                    </section>
                </td>
                <td>
                    <div class="d-flex">
                        <section>
                            <div class="d-flex">
                                <div class="w-100">
                                    <a href="/collections/items/{{ $item->title }}/detail" class="link-primary">
                                        <h6>{{ $item->title }}</h6>
                                    </a>
                                </div>
                            </div>
                            <p>
                                Author: {{ $item->author }} <br>
                                <i>Checked out {{ $item->count }}
                                    {{ $item->count > 1 ? 'times' : 'time' }}</i>
                            </p>
                        </section>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
