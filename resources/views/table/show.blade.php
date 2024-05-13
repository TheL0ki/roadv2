<x-layout>
        <div class="flex justify-center pt-4">
            <table class="table-auto border-collapse w-full">
                <thead class="border-b border-white/20">
                    <th>Name</th>
                    @for ($i = 1; $i <= $date->format('t'); $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        <tr class="border-b border-r border-white/20 even:bg-black/30">
                            <td  class="border-r border-l border-white/20"><a href="/schedule/change/{{ $item->id }}"> {{ $item->firstName }} {{ $item->lastName }} </a></td>
                            @for ($i = 1; $i <= $date->format('t'); $i++)
                                <td class="border-l border-white/20 w-[50px] text-center">
                                    @isset ($table[$item->id][$i])
                                        {{ $table[$item->id][$i]->shift->display }}
                                    @endisset
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</x-layout>