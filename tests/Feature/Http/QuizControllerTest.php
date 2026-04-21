<?php

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;
use Laravel\Pulse\Facades\Pulse;

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
            ->has('quote')
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

it('cycles through all questions before repeating any', function () {
    $module = Module::factory()->create();
    $questions = Question::factory(3)
        ->for($module)
        ->has(Answer::factory(4))
        ->create();

    $seenIds = [];

    for ($i = 0; $i < 3; $i++) {
        $response = $this->get("/module/{$module->slug}");
        $response->assertOk();

        $id = $response->viewData('page')['props']['question']['id'];
        $seenIds[] = $id;
    }

    expect($seenIds)->toHaveCount(3);
    expect(array_unique($seenIds))->toHaveCount(3);
    expect(array_values(array_intersect($questions->pluck('id')->all(), $seenIds)))
        ->toEqualCanonicalizing($questions->pluck('id')->all());
});

it('resets the shuffle bag once all questions have been seen', function () {
    $module = Module::factory()->create();
    Question::factory(2)
        ->for($module)
        ->has(Answer::factory(4))
        ->create();

    $this->get("/module/{$module->slug}");
    $this->get("/module/{$module->slug}");

    $response = $this->get("/module/{$module->slug}");
    $response->assertOk();
    expect($response->viewData('page')['props']['question']['id'])->not->toBeNull();
});

it('records a module_view pulse entry when viewing a module', function () {
    Pulse::startRecording();

    $module = Module::factory()->create();
    Question::factory()->for($module)->has(Answer::factory(4))->create();

    $this->get("/module/{$module->slug}");

    Pulse::ingest();

    $this->assertDatabaseHas('pulse_entries', [
        'type' => 'module_view',
        'key' => $module->slug,
    ]);
});
