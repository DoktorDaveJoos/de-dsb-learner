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
