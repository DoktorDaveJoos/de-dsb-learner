<?php

use App\Models\Answer;
use App\Models\Question;

it('belongs to a question', function () {
    $question = Question::factory()->create();
    $answer = Answer::factory()->for($question)->create();

    expect($answer->question->id)->toBe($question->id);
});

it('defaults to incorrect', function () {
    $answer = Answer::factory()->create();

    expect($answer->is_correct)->toBeFalse();
});

it('can be marked as correct', function () {
    $answer = Answer::factory()->correct()->create();

    expect($answer->is_correct)->toBeTrue();
});
