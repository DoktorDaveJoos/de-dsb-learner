<?php

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;

it('displays a random question for a module', function () {
    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();
    Answer::factory(2)->correct()->for($question)->create();
    Answer::factory(2)->for($question)->create();

    $response = $this->get("/module/{$module->slug}");

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/quiz')
        ->has('module', fn ($module) => $module
            ->has('id')
            ->has('name')
            ->has('slug')
            ->etc()
        )
        ->has('question', fn ($q) => $q
            ->has('id')
            ->has('text')
            ->has('explanation')
            ->has('source')
            ->has('answers', 4)
            ->etc()
        )
    );
});

it('excludes the specified question', function () {
    $module = Module::factory()->create();
    $q1 = Question::factory()->for($module)->create();
    Answer::factory(4)->for($q1)->create();
    $q2 = Question::factory()->for($module)->create();
    Answer::factory(4)->for($q2)->create();

    $response = $this->get("/module/{$module->slug}?exclude={$q1->id}");

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/quiz')
        ->where('question.id', $q2->id)
    );
});

it('ignores exclude when only one question exists', function () {
    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();
    Answer::factory(4)->for($question)->create();

    $response = $this->get("/module/{$module->slug}?exclude={$question->id}");

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/quiz')
        ->where('question.id', $question->id)
    );
});

it('returns 404 for non-existent module', function () {
    $response = $this->get('/module/non-existent');

    $response->assertNotFound();
});
