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
    private const COLORS = [
        '#8b5cf6',
        '#06b6d4',
        '#f59e0b',
        '#10b981',
        '#f43f5e',
        '#6366f1',
        '#14b8a6',
        '#e879f9',
    ];

    public function render(): Renderable
    {
        [$modules, $time, $runAt] = $this->remember(
            fn () => $this->graph(['module_view'], 'count'),
        );

        $moduleColors = $modules->keys()->mapWithKeys(fn ($slug) => [
            $slug => self::COLORS[abs(crc32((string) $slug)) % count(self::COLORS)],
        ]);

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('module-views-chart-update', modules: $modules, moduleColors: $moduleColors);
        }

        return View::make('livewire.pulse.module-views-graph', [
            'modules' => $modules,
            'moduleColors' => $moduleColors,
            'time' => $time,
            'runAt' => $runAt,
        ]);
    }
}
