<x-layout>
    <div class="">
        <style>
            .multiline-ellipsis {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                -webkit-line-clamp: 2;
                font-size: 12px;
                height: 36px;
                line-height: 1.5em;
                max-height: 3em;
                color: black;
            }
        </style>
        <div class="d-block mb-4">
            @foreach ($items as $item)
                <div class="float-start m-3" style="width: 190px;">
                    <span class="multiline-ellipsis">{{ $item->title }}</span>
                    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($item->barcode, 'EAN13', 2, 70, array(0,0,0), true) !!}" alt="barcode" /><br>
                </div>
            @endforeach
        </div>
    </div>
    <x-slot:script>
        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    </x-slot:script>
</x-layout>
