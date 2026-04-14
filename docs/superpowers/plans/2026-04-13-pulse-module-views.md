# Pulse Module Views Cards Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add two custom Pulse dashboard cards — a time-series line chart showing module views over time, and a ranked list showing the most popular modules.

**Architecture:** Record a `module_view` entry via `Pulse::record()` in `QuizController@show`. Two Livewire card components read this data: `ModuleViewsGraph` uses `$this->graph()` for Chart.js line charts, `PopularModules` uses `$this->aggregate()` for a ranked bar list. Both are added to the Pulse dashboard Blade view.

**Tech Stack:** Laravel Pulse (custom cards), Livewire 4, Chart.js (bundled with Pulse), Blade components

---

### Task 1: Record module views in QuizController

**Files:**
- Modify: `app/Http/Controllers/QuizController.php:1-40`
- Test: `tests/Feature/Http/QuizControllerTest.php`

- [ ] **Step 1: Write the failing test**

Add to the bottom of `tests/Feature/Http/QuizControllerTest.php`:

```php
use Laravel\Pulse\Facades\Pulse;

it('records a pulse module_view entry', function () {
    Pulse::fake();

    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();
    Answer::factory(4)->for($question)->create();

    $this->get("/module/{$module->slug}");

    Pulse::assertRecorded('module_view', function ($entry) use ($module) {
        return $entry->key === $module->slug;
    });
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter="records a pulse module_view entry"`
Expected: FAIL — no `module_view` entry recorded

- [ ] **Step 3: Add Pulse::record to QuizController**

In `app/Http/Controllers/QuizController.php`, add the import and the record call. The full file becomes:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Pulse\Facades\Pulse;

class QuizController extends Controller
{
    public function show(Request $request, Module $module): Response
    {
        Pulse::record('module_view', $module->slug)->count();

        $exclude = $request->integer('exclude');

        $question = $module->questions()
            ->with('answers')
            ->when($exclude, fn ($q) => $q->where('id', '!=', $exclude))
            ->inRandomOrder()
            ->firstOr(fn () => $module->questions()->with('answers')->inRandomOrder()->firstOrFail());

        $question->setRelation('answers', $question->answers->shuffle());

        return Inertia::render('modules/quiz', [
            'module' => $module->only('id', 'name', 'slug'),
            'question' => [
                'id' => $question->id,
                'text' => $question->text,
                'explanation' => $question->explanation,
                'quote' => $question->quote,
                'source' => $question->source,
                'answers' => $question->answers->map(fn ($a) => [
                    'id' => $a->id,
                    'text' => $a->text,
                    'is_correct' => $a->is_correct,
                ])->values(),
            ],
        ]);
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --compact --filter="records a pulse module_view entry"`
Expected: PASS

- [ ] **Step 5: Run full QuizController test suite**

Run: `php artisan test --compact tests/Feature/Http/QuizControllerTest.php`
Expected: All 4 tests PASS

- [ ] **Step 6: Run Pint**

Run: `vendor/bin/pint --dirty --format agent`

- [ ] **Step 7: Commit**

```bash
git add app/Http/Controllers/QuizController.php tests/Feature/Http/QuizControllerTest.php
git commit -m "feat: record module_view pulse entries in QuizController"
```

---

### Task 2: Create ModuleViewsGraph Livewire card (time-series chart)

**Files:**
- Create: `app/Livewire/Pulse/ModuleViewsGraph.php`
- Create: `resources/views/livewire/pulse/module-views-graph.blade.php`

- [ ] **Step 1: Create the Livewire component**

Create `app/Livewire/Pulse/ModuleViewsGraph.php`:

```php
<?php

namespace App\Livewire\Pulse;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Livewire;

#[Lazy]
class ModuleViewsGraph extends Card
{
    /**
     * The pre-defined chart colors for modules.
     *
     * @var array<int, string>
     */
    protected array $colors = [
        '#8b5cf6', // violet
        '#06b6d4', // cyan
        '#f59e0b', // amber
        '#10b981', // emerald
        '#f43f5e', // rose
        '#6366f1', // indigo
        '#14b8a6', // teal
        '#e879f9', // fuchsia
    ];

    public function render(): Renderable
    {
        [$modules, $time, $runAt] = $this->remember(
            fn () => $this->graph(['module_view'], 'count'),
        );

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('module-views-chart-update', modules: $modules);
        }

        return View::make('livewire.pulse.module-views-graph', [
            'modules' => $modules,
            'colors' => $this->colors,
            'time' => $time,
            'runAt' => $runAt,
        ]);
    }
}
```

- [ ] **Step 2: Create the Blade view**

Create `resources/views/livewire/pulse/module-views-graph.blade.php`:

```blade
<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Module Views"
        x-bind:title="`Time: {{ number_format($time) }}ms; Run at: ${formatDate('{{ $runAt }}')};`"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-pulse::icons.eye />
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
```

- [ ] **Step 3: Run Pint**

Run: `vendor/bin/pint --dirty --format agent`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Pulse/ModuleViewsGraph.php resources/views/livewire/pulse/module-views-graph.blade.php
git commit -m "feat: add ModuleViewsGraph Pulse card with Chart.js line chart"
```

---

### Task 3: Create PopularModules Livewire card (ranked list)

**Files:**
- Create: `app/Livewire/Pulse/PopularModules.php`
- Create: `resources/views/livewire/pulse/popular-modules.blade.php`

- [ ] **Step 1: Create the Livewire component**

Create `app/Livewire/Pulse/PopularModules.php`:

```php
<?php

namespace App\Livewire\Pulse;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;

#[Lazy]
class PopularModules extends Card
{
    public function render(): Renderable
    {
        [$modules, $time, $runAt] = $this->remember(
            fn () => $this->aggregate('module_view', 'count', limit: 10),
        );

        return View::make('livewire.pulse.popular-modules', [
            'modules' => $modules,
            'time' => $time,
            'runAt' => $runAt,
        ]);
    }
}
```

- [ ] **Step 2: Create the Blade view**

Create `resources/views/livewire/pulse/popular-modules.blade.php`:

```blade
<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Popular Modules"
        x-bind:title="`Time: {{ number_format($time) }}ms; Run at: ${formatDate('{{ $runAt }}')};`"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-pulse::icons.chart-bar />
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($modules->isEmpty())
            <x-pulse::no-results />
        @else
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
                                @php
                                    $maxCount = $modules->first()->count;
                                    $percentage = $maxCount > 0 ? ($module->count / $maxCount) * 100 : 0;
                                @endphp
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
```

- [ ] **Step 3: Run Pint**

Run: `vendor/bin/pint --dirty --format agent`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Pulse/PopularModules.php resources/views/livewire/pulse/popular-modules.blade.php
git commit -m "feat: add PopularModules Pulse card with ranked bar list"
```

---

### Task 4: Update Pulse dashboard layout

**Files:**
- Modify: `resources/views/vendor/pulse/dashboard.blade.php`

- [ ] **Step 1: Update dashboard to include new cards and remove irrelevant ones**

Replace the contents of `resources/views/vendor/pulse/dashboard.blade.php` with:

```blade
<x-pulse>
    <livewire:pulse.servers cols="full" />

    <livewire:pulse.module-views-graph cols="8" rows="2" />

    <livewire:pulse.popular-modules cols="4" rows="2" />

    <livewire:pulse.slow-queries cols="8" />

    <livewire:pulse.exceptions cols="4" />

    <livewire:pulse.slow-requests cols="6" />

    <livewire:pulse.cache cols="6" />
</x-pulse>
```

- [ ] **Step 2: Verify the dashboard loads in the browser**

Run: Use `get-absolute-url` to get the Pulse URL, then open `{url}/pulse` in a browser.
Expected: Dashboard loads with the new Module Views graph and Popular Modules cards (they will show "No results" until quiz pages are visited).

- [ ] **Step 3: Commit**

```bash
git add resources/views/vendor/pulse/dashboard.blade.php
git commit -m "feat: update Pulse dashboard with module view cards, remove unused cards"
```

---

### Task 5: Disable unused Pulse recorders

**Files:**
- Modify: `.env`

- [ ] **Step 1: Add env vars to disable unused recorders**

Add these lines to `.env`:

```
PULSE_QUEUES_ENABLED=false
PULSE_SLOW_JOBS_ENABLED=false
PULSE_USER_JOBS_ENABLED=false
PULSE_SLOW_OUTGOING_REQUESTS_ENABLED=false
PULSE_USER_REQUESTS_ENABLED=false
```

- [ ] **Step 2: Commit**

```bash
git add .env
git commit -m "chore: disable unused Pulse recorders"
```

Note: Only commit `.env` if this project tracks it in git. If `.env` is gitignored (check first), add these to `.env.example` instead and document the change.

---

### Task 6: End-to-end smoke test

- [ ] **Step 1: Run the full test suite**

Run: `php artisan test --compact`
Expected: All tests pass, including the new Pulse recording test.

- [ ] **Step 2: Manual browser test**

1. Open the module index page in the browser
2. Click into a module to trigger quiz views (visit 3-4 different modules a few times)
3. Open `/pulse` dashboard
4. Verify: Module Views graph shows lines appearing for visited modules
5. Verify: Popular Modules card shows a ranked list with view counts and bar indicators
6. Verify: Other cards (Servers, Slow Queries, Exceptions, Slow Requests, Cache) still render correctly

- [ ] **Step 3: Run Pint on all modified files**

Run: `vendor/bin/pint --dirty --format agent`
