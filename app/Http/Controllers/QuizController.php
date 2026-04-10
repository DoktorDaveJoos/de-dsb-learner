<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    public function show(Request $request, Module $module): Response
    {
        $exclude = $request->integer('exclude');

        $question = $module->questions()
            ->with('answers')
            ->when($exclude, fn ($q) => $q->where('id', '!=', $exclude))
            ->inRandomOrder()
            ->firstOr(fn () => $module->questions()->with('answers')->inRandomOrder()->firstOrFail());

        $question->setRelation('answers', $question->answers->shuffle());

        return Inertia::render('modules/quiz', [
            'module' => $module->only('id', 'name', 'slug'),
            'question' => [
                'id' => $question->id,
                'text' => $question->text,
                'explanation' => $question->explanation,
                'source' => $question->source,
                'answers' => $question->answers->map(fn ($a) => [
                    'id' => $a->id,
                    'text' => $a->text,
                    'is_correct' => $a->is_correct,
                ])->values(),
            ],
        ]);
    }
}
