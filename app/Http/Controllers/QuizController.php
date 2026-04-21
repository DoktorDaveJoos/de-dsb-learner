<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Pulse\Facades\Pulse;

class QuizController extends Controller
{
    public function show(Request $request, Module $module): Response
    {
        Pulse::record('module_view', $module->slug)->count();

        $exclude = $request->integer('exclude');
        $sessionKey = "quiz.seen.{$module->slug}";
        $seen = $request->session()->get($sessionKey, []);

        $question = $module->questions()
            ->with('answers')
            ->whereNotIn('id', $seen)
            ->when($exclude, fn ($q) => $q->where('id', '!=', $exclude))
            ->inRandomOrder()
            ->first();

        if (! $question) {
            $seen = [];
            $question = $module->questions()
                ->with('answers')
                ->when($exclude, fn ($q) => $q->where('id', '!=', $exclude))
                ->inRandomOrder()
                ->firstOr(fn () => $module->questions()->with('answers')->inRandomOrder()->firstOrFail());
        }

        $request->session()->put($sessionKey, array_values(array_unique([...$seen, $question->id])));

        $question->setRelation('answers', $question->answers->shuffle());

        return Inertia::render('modules/quiz', [
            'module' => $module->only('id', 'name', 'slug'),
            'question' => [
                'id' => $question->id,
                'text' => $question->text,
                'explanation' => $question->explanation,
                'quote' => $question->quote,
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
