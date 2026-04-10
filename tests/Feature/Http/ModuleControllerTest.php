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
        ->has('modules', fn ($modules) => $modules
            ->each(fn ($m) => $m->has('name')->has('questions_count')->etc())
        )
    );
});

it('hides modules without questions', function () {
    $emptyModule = Module::factory()->create();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('modules/index')
        ->where('modules', fn ($modules) => collect($modules)->where('name', $emptyModule->name)->isEmpty())
    );
});
