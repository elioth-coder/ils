<x-layout>
    <div class="text-center px-5">
        <style>
            @media print {
                div {
                    break-inside: avoid;
                }
            }
        </style>
        <div class="d-inline-block mb-4">
            @foreach ($patrons as $patron)
                <div class="no-break p-0 float-start my-3 border" style="width: 350px; position: relative;">
                    <img src="/images/print/card_maker/front.png" style="width: 100%;" alt="">
                    @if ($patron->profile)
                        <img src="/storage/images/users/{{ $patron->profile }}"
                            style="position:absolute; top: 79px; left: 6px; width: 105px;" alt="Profile" />
                    @else
                        <img src="/images/print/card_maker/{{ $patron->gender }}.png"
                            style="position:absolute; top: 79px; left: 6px; width: 105px;" alt="Profile" />
                    @endif
                    <section style="font-size: 16px; position: absolute; top: 187px; left: 6px; width: 105px;"
                        class="text-center text-uppercase fw-semibold bg-danger-subtle">
                        {{ $patron->program ?? '--' }}
                    </section>
                    <section style="font-size: 11px; position: absolute; top: 72px; left: 120px; width: 220px;"
                        class="text-center text-uppercase fw-semibold">
                        {{ $patron->card_number }}
                    </section>
                    <section style="font-size: 11px; position: absolute; top: 108px; left: 120px; width: 220px;"
                        class="text-center text-uppercase fw-semibold">
                        {{ $patron->first_name }}
                        {{ $patron->middle_name }}
                        {{ $patron->last_name }}
                    </section>
                    <section style="font-size: 11px; position: absolute; top: 138px; left: 120px; width: 220px;"
                        class="text-center text-uppercase fw-semibold">
                        {{ $patron->mobile_number ?? '--' }}
                    </section>
                    <section style="position: absolute; bottom: 5px; right: 5px;">
                        <div class="mx-auto" style="width: 65px;">{!! QrCode::size(65)->generate($patron->card_number) !!}</div>
                    </section>
                </div>
                <div class="no-break p-0 float-start my-3 border" style="width: 350px; position: relative;">
                    <img src="/images/print/card_maker/back.png" style="width: 100%;" alt="">
                    <img style="position: absolute; height: 35px; right: 10px; bottom: 43px;"
                        src="data:image/png;base64,{!! DNS1D::getBarcodePNG($patron->card_number, 'C39', 2, 70, [0, 0, 0], true) !!}" alt="barcode" /><br>
                </div>
            @endforeach
        </div>
    </div>
    <x-slot:script>
        <script>
            window.onload = function() {
                // window.print();
            }
        </script>
    </x-slot:script>
</x-layout>
