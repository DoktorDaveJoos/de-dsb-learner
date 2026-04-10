<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Inertia\Inertia;
use Inertia\Response;

class ModuleController extends Controller
{
    public function index(): Response
    {
        $modules = Module::query()
            ->withCount('questions')
            ->whereHas('questions')
            ->orderBy('name')
            ->get();

        return Inertia::render('modules/index', [
            'modules' => $modules,
        ]);
    }
}
