<?php

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;

it('belongs to a module', function () {
    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();

    expect($question->module->id)->toBe($module->id);
});

it('has many answers', function () {
    $question = Question::factory()->create();
    Answer::factory(4)->for($question)->create();

    expect($question->answers)->toHaveCount(4);
});

it('can have correct and incorrect answers', function () {
    $question = Question::factory()->create();
    Answer::factory(2)->correct()->for($question)->create();
    Answer::factory(2)->for($question)->create();

    $correct = $question->answers->where('is_correct', true);
    $incorrect = $question->answers->where('is_correct', false);

    expect($correct)->toHaveCount(2);
    expect($incorrect)->toHaveCount(2);
});
