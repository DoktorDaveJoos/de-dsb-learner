<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Popular Modules"
        x-bind:title="`Time: {{ number_format($time) }}ms; Run at: ${formatDate('{{ $runAt }}')};`"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-pulse::icons.arrow-trending-up />
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($modules->isEmpty())
            <x-pulse::no-results />
        @else
            @php $maxCount = $modules->first()->count; @endphp
            <x-pulse::table>
                <colgroup>
                    <col width="0%" />
                    <col width="100%" />
                    <col width="0%" />
                </colgroup>
                <x-pulse::thead>
                    <tr>
                        <x-pulse::th class="text-left">#</x-pulse::th>
                        <x-pulse::th class="text-left">Module</x-pulse::th>
                        <x-pulse::th class="text-right">Views</x-pulse::th>
                    </tr>
                </x-pulse::thead>
                <tbody>
                    @foreach ($modules as $index => $module)
                        <tr wire:key="{{ $module->key }}" class="h-2">
                            <x-pulse::td numeric class="text-gray-700 dark:text-gray-300 font-bold">
                                {{ $index + 1 }}
                            </x-pulse::td>
                            <x-pulse::td class="max-w-[1px]">
                                <code class="block text-xs text-gray-900 dark:text-gray-100 truncate" title="{{ $module->key }}">
                                    {{ $module->key }}
                                </code>
                                @php $percentage = $maxCount > 0 ? ($module->count / $maxCount) * 100 : 0; @endphp
                                <div class="mt-1 w-full h-1 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                    <div class="h-full rounded-full bg-violet-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </x-pulse::td>
                            <x-pulse::td numeric class="text-gray-700 dark:text-gray-300 font-bold">
                                {{ number_format($module->count) }}
                            </x-pulse::td>
                        </tr>
                    @endforeach
                </tbody>
            </x-pulse::table>
        @endif
    </x-pulse::scroll>
</x-pulse::card>
