<?php

use App\Models\Module;

it('seeds the M1 - Informationssicherheitsbeauftragter module via migration', function () {
    $module = Module::where('slug', 'm1-informationssicherheitsbeauftragter')->first();

    expect($module)->not->toBeNull()
        ->and($module->name)->toBe('M1 - Informationssicherheitsbeauftragter');

    expect($module->questions()->count())->toBeGreaterThanOrEqual(45);
});

it('seeds well-formed questions for every M1 question', function () {
    $module = Module::where('slug', 'm1-informationssicherheitsbeauftragter')->firstOrFail();

    $module->questions()->with('answers')->get()->each(function ($question) {
        expect($question->text)->not->toBeEmpty()
            ->and($question->explanation)->not->toBeEmpty()
            ->and($question->quote)->not->toBeEmpty()
            ->and($question->source)->not->toBeEmpty()
            ->and($question->answers->count())->toBeGreaterThanOrEqual(3)
            ->and($question->answers->where('is_correct', true)->count())->toBeGreaterThanOrEqual(1)
            ->and($question->answers->where('is_correct', false)->count())->toBeGreaterThanOrEqual(1);
    });
});

it('lists the M1 module on the homepage', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/index')
        ->where('modules', fn ($modules) => collect($modules)
            ->where('slug', 'm1-informationssicherheitsbeauftragter')
            ->isNotEmpty())
    );
});
