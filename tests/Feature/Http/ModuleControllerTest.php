<?php

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;

it('displays modules with questions', function () {
    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();
    Answer::factory(4)->for($question)->create();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/index')
        ->has('modules', 1)
        ->where('modules.0.name', $module->name)
        ->where('modules.0.questions_count', 1)
    );
});

it('hides modules without questions', function () {
    Module::factory()->create();

    $moduleWithQuestions = Module::factory()->create();
    $question = Question::factory()->for($moduleWithQuestions)->create();
    Answer::factory(4)->for($question)->create();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/index')
        ->has('modules', 1)
        ->where('modules.0.name', $moduleWithQuestions->name)
    );
});
