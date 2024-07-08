<x-layout>
    <div class="space-y-4 pt-4">
        <div class="grid grid-cols-2 space-x-2">
            <div class="grid grid-cols-2 space-x-2 space-y-2">

                <div class="flex flex-col space-y-2">
                    <label for="shift">Shift</label>
                    <x-form.select name="shift">
                        <option>X</option>
                    </x-form.select>

                    <label for="month">Month</label>
                    <x-form.select name="month">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </x-form.select>

                    <label for="year">Year</label>
                    <x-form.select name="year">
                        <option>2024</option>
                    </x-form.select>
                </div>

                <div>
                    <x-table.table>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Monday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Tuesday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Wednesday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Thursday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Friday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Saturday
                            </x-table.body-cell>
                        </x-table.table-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Sunday
                            </x-table.body-cell>
                        </x-table.table-row>
                    </x-table.table>
                </div>

                <div class="col-span-2">
                    <x-table.table>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Employee #1
                            </x-table.body-cell>
                        </x-table.body-row>
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell class="text-center">
                                <input type="checkbox" />
                            </x-table.body-cell>
                            <x-table.body-cell>
                                Employee #2
                            </x-table.body-cell>
                        </x-table.body-row>
                    </x-table.table>
                </div>

            </div>
            <form>
                @csrf
                @method('POST')
                <div class="flex flex-col space-y-2">
                    <label for="day">Day</label>
                    <x-form.select name="day">
                        <option>X</option>
                    </x-form.select>
                    <label for="month">Month</label>
                    <x-form.select name="month">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </x-form.select>
                    <label for="year">Year</label>
                    <x-form.select name="year">
                        <option>2024</option>
                    </x-form.select>
                    <div>
                        <x-button>Save</x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>