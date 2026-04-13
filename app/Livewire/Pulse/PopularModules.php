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
