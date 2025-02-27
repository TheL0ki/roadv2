<x-layout>
    <div class="space-y-4 pt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <form action="/batch/update" method="POST">
                @csrf
                @method('POST')
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-2">
                        <div>
                            <label for="shift">Shift</label>
                            <x-form.select name="shift">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->display }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div>
                            <label for="month">Month</label>
                            <x-form.select name="month">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div>
                            <label for="year">Year</label>
                            <x-form.select name="year">
                                <option value="{{ $date->format('Y')-2}}">{{ $date->format('Y')-2 }}</option>
                                <option value="{{ $date->format('Y')-1}}">{{ $date->format('Y')-1 }}</option>
                                <option value="{{ $date->format('Y')}}" selected="selected">{{ $date->format('Y') }}</option>
                                <option value="{{ $date->format('Y')+1}}">{{ $date->format('Y')+1 }}</option>
                                <option value="{{ $date->format('Y')+2}}">{{ $date->format('Y')+2 }}</option>
                            </x-form.select>
                        </div>
                    </div>
                    <div>
                        <x-table.table>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="1"/>
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Monday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="2" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Tuesday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="3" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Wednesday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="4" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Thursday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="5" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Friday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="6" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Saturday
                                </x-table.body-cell>
                            </x-table.table-row>
                            <x-table.body-row class="!h-12">
                                <x-table.body-cell class="text-center">
                                    <input type="checkbox" name="weekday[]" value="7" />
                                </x-table.body-cell>
                                <x-table.body-cell>
                                    Sunday
                                </x-table.body-cell>
                            </x-table.table-row>
                        </x-table.table>
                    </div>
                    <div class="col-span-2">
                        <x-table.table>
                            @foreach ($users as $user)
                                <x-table.body-row class="!h-12">
                                    <x-table.body-cell class="text-center">
                                        <input type="checkbox" name="user[]" value="{{ $user->id }}"/>
                                    </x-table.body-cell>
                                    <x-table.body-cell>
                                        {{ $user->firstName }} {{ $user->lastName}}
                                    </x-table.body-cell>
                                </x-table.body-row>
                            @endforeach
                        </x-table.table>
                    </div>
                    <div>
                        <x-button>Save</x-button>
                    </div>
                </div>
            </form>
            <form action="{{ route('batch.holiday') }}" method="POST">
            @csrf
            @method('POST')
                <div class="grid grid-cols-1">
                    <div class="space-y-2">
                        @if(count($holidays) > 1)
                            <div>
                                <label for="shift">Holiday</label>
                                <x-form.select name="holiday">
                                    @foreach ($holidays as $holiday)
                                        <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                        @endif
                        <div>
                            <label for="day">Day</label>
                            <x-form.select name="day">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div>
                            <label for="month">Month</label>
                            <x-form.select name="month">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div>
                            <label for="year">Year</label>
                            <x-form.select name="year">
                                <option value="{{ $date->format('Y')-2}}">{{ $date->format('Y')-2 }}</option>
                                <option value="{{ $date->format('Y')-1}}">{{ $date->format('Y')-1 }}</option>
                                <option value="{{ $date->format('Y')}}" selected="selected">{{ $date->format('Y') }}</option>
                                <option value="{{ $date->format('Y')+1}}">{{ $date->format('Y')+1 }}</option>
                                <option value="{{ $date->format('Y')+2}}">{{ $date->format('Y')+2 }}</option>
                            </x-form.select>
                        </div>
                        <div>
                            <x-button>Save</x-button>
                            @if(count($holidays) === 1)
                                <input type="hidden" name="holiday" value="{{ $holidays[0]->id }}" readonly>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</x-layout>