<?php

use App\Models\Module;
use App\Models\Question;

it('has many questions', function () {
    $module = Module::factory()->create();
    $questions = Question::factory(3)->for($module)->create();

    expect($module->questions)->toHaveCount(3);
    expect($module->questions->first()->id)->toBe($questions->first()->id);
});

it('stores a slug', function () {
    $module = Module::factory()->create(['name' => 'Netzwerksicherheit', 'slug' => 'netzwerksicherheit']);

    expect($module->slug)->toBe('netzwerksicherheit');
});
