<?php

use App\Models\Module;
use App\Models\Question;

it('has many questions', function () {
    $module = Module::factory()->create();
    $questions = Question::factory(3)->for($module)->create();

    expect($module->questions)->toHaveCount(3);
    expect($module->questions->first()->id)->toBe($questions->first()->id);
});

it('generates a slug', function () {
    $module = Module::factory()->create(['name' => 'IT-Grundschutz', 'slug' => 'it-grundschutz']);

    expect($module->slug)->toBe('it-grundschutz');
});
