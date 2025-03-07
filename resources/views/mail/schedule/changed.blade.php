@php
    $table = [];

    for($t = 1; $t < $date->format('t'); $t++) {
        $table[$t] = null;
    }

    foreach ($schedule as $item) {
        $table[$item->day] = $item->shift;
    }
@endphp

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="px-2 md:px-10">
    <div class="grid gap-4">
        <h1 class="text-2xl font-bold">Schedule changed</h1>
        <div>
            <p>
                Hallo {{ $user->firstName . ' ' . $user->lastName }},
            </p>
            <p>
                Dein Dienstplan wurde angepasst. Dein neuer Dienstplan sieht wie folgt aus:
            </p>
        </div>
        <div>
            <table class="border-collapse border border-black">
                <tr>
                    @for ($i = 1; $i <= 15; $i++)
                        <td class="text-center w-[50px] border border-black">{{ $i }}</div>
                    @endfor
                </tr>
                <tr>
                    @for ($i = 1; $i <= 15; $i++)
                        <td class="text-center w-[50px] border border-black" @if($table[$i] !== null) style="background-color: {{ $item->shift->color }}; color: {{ $item->shift->textColor }};" @endif>@if($table[$i] !== null){{ $table[$i]->display }}@endif</div>
                    @endfor
                </tr>
                <tr>
                    @for ($i = 16; $i <= $date->format('t'); $i++)
                        <td class="text-center w-[50px] border border-black">{{ $i }}</div>
                    @endfor
                </tr>
                <tr>
                    @for ($i = 16; $i <= $date->format('t'); $i++)
                        <td class="text-center w-[50px] border border-black" @if($table[$i] !== null) style="background-color: {{ $item->shift->color }}; color: {{ $item->shift->textColor }};" @endif>@if($table[$i] !== null){{ $table[$i]->display }}@endif</div>
                    @endfor
                </tr>
            </div>
        </div>
    </div>
</div>