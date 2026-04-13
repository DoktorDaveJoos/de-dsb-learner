<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Module Views"
        x-bind:title="`Time: {{ number_format($time) }}ms; Run at: ${formatDate('{{ $runAt }}')};`"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-pulse::icons.cursor-arrow-rays />
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap gap-4">
                @foreach ($modules as $slug => $readings)
                    @php $color = $colors[abs(crc32($slug)) % count($colors)]; @endphp
                    <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                        <div class="h-0.5 w-3 rounded-full" style="background: {{ $color }}"></div>
                        {{ $slug }}
                    </div>
                @endforeach
            </div>
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($modules->isEmpty())
            <x-pulse::no-results />
        @else
            @php
                $highest = $modules->flatMap(fn ($readings) => $readings->get('module_view', collect()))->max() ?: 1;
            @endphp
            <div class="mx-px mb-px">
                <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-violet-500 rounded after:[--triangle-size:4px] after:border-l-violet-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent">
                    {{ number_format($highest) }}
                </div>

                <div
                    wire:ignore
                    class="h-36"
                    x-data="moduleViewsChart({
                        modules: @js($modules),
                        colors: @js($colors),
                    })"
                >
                    <canvas x-ref="canvas" class="ring-1 ring-gray-900/5 dark:ring-gray-100/10 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm"></canvas>
                </div>
            </div>
        @endif
    </x-pulse::scroll>
</x-pulse::card>

@script
<script>
Alpine.data('moduleViewsChart', (config) => ({
    init() {
        const slugs = Object.keys(config.modules)
        const firstSlug = slugs[0]
        const firstReadings = config.modules[firstSlug]?.module_view ?? {}
        const labels = Object.keys(firstReadings).map(formatDate)

        const datasets = slugs.map((slug, i) => {
            const color = config.colors[Math.abs(this.hashCode(slug)) % config.colors.length]
            return {
                label: slug,
                borderColor: color,
                data: Object.values(config.modules[slug]?.module_view ?? {}),
                order: i,
            }
        })

        let chart = new Chart(this.$refs.canvas, {
            type: 'line',
            data: { labels, datasets },
            options: {
                maintainAspectRatio: false,
                layout: {
                    autoPadding: false,
                    padding: { top: 1 },
                },
                datasets: {
                    line: {
                        borderWidth: 2,
                        borderCapStyle: 'round',
                        pointHitRadius: 10,
                        pointStyle: false,
                        tension: 0.2,
                        spanGaps: false,
                        segment: {
                            borderColor: (ctx) => ctx.p0.raw === 0 && ctx.p1.raw === 0 ? 'transparent' : undefined,
                        },
                    },
                },
                scales: {
                    x: { display: false },
                    y: { display: false, min: 0, max: this.highest(config.modules) },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        position: 'nearest',
                        intersect: false,
                        callbacks: {
                            beforeBody: (context) => context
                                .map(item => `${item.dataset.label}: ${item.formattedValue}`)
                                .join(', '),
                            label: () => null,
                        },
                    },
                },
            },
        })

        Livewire.on('module-views-chart-update', ({ modules }) => {
            if (chart === undefined) return

            const newSlugs = Object.keys(modules)
            const firstData = modules[newSlugs[0]]?.module_view ?? {}
            chart.data.labels = Object.keys(firstData).map(formatDate)
            chart.options.scales.y.max = this.highest(modules)

            newSlugs.forEach((slug, i) => {
                if (chart.data.datasets[i]) {
                    chart.data.datasets[i].data = Object.values(modules[slug]?.module_view ?? {})
                }
            })

            chart.update()
        })
    },
    highest(modules) {
        return Math.max(
            ...Object.values(modules).map(
                readings => Math.max(...Object.values(readings.module_view ?? {}))
            )
        ) || 1
    },
    hashCode(str) {
        let hash = 0
        for (let i = 0; i < str.length; i++) {
            hash = ((hash << 5) - hash) + str.charCodeAt(i)
            hash |= 0
        }
        return hash
    },
}))
</script>
@endscript
