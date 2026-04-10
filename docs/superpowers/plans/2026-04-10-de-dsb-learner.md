# de-dsb Learner Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a public quiz-based learning platform for Informationssicherheit where users pick a module and answer randomly-served multiple-choice questions with immediate feedback, explanations, and source citations.

**Architecture:** Two-page Inertia SPA — module list + quiz page. Backend serves random questions via standard Inertia controllers. Questions are generated offline by Claude Code and seeded via migrations. No auth, no tracking, no API endpoints.

**Tech Stack:** Laravel 13, React 19, Inertia v3, Tailwind v4, TypeScript, shadcn/ui, Wayfinder, Pest, SQLite (dev) / Serverless Postgres (prod on Laravel Cloud)

---

## File Structure

### Backend (PHP)

| File | Responsibility |
|------|---------------|
| `app/Models/Module.php` | Module model with `slug`, `questions` relationship, `questionsCount` scope |
| `app/Models/Question.php` | Question model with `module`, `answers` relationships |
| `app/Models/Answer.php` | Answer model with `question` relationship |
| `database/migrations/xxxx_create_modules_table.php` | `modules` table: id, name, slug, description, timestamps |
| `database/migrations/xxxx_create_questions_table.php` | `questions` table: id, module_id (FK), text, explanation, source, timestamps |
| `database/migrations/xxxx_create_answers_table.php` | `answers` table: id, question_id (FK), text, is_correct (bool), timestamps |
| `app/Http/Controllers/ModuleController.php` | `index()` — returns all modules with question counts |
| `app/Http/Controllers/QuizController.php` | `show(Module $module)` — returns module + random question + answers |
| `routes/web.php` | Two routes: `GET /` and `GET /module/{module:slug}` |

### Frontend (React/TypeScript)

| File | Responsibility |
|------|---------------|
| `resources/js/types/index.ts` | TypeScript types for Module, Question, Answer |
| `resources/js/pages/modules/index.tsx` | Module list page — grid of cards |
| `resources/js/pages/modules/quiz.tsx` | Quiz page — question display, answer selection, feedback |

### Tests

| File | Responsibility |
|------|---------------|
| `tests/Feature/Models/ModuleTest.php` | Module model relationships and scopes |
| `tests/Feature/Models/QuestionTest.php` | Question model relationships |
| `tests/Feature/Models/AnswerTest.php` | Answer model relationships |
| `tests/Feature/Http/ModuleControllerTest.php` | Module list endpoint tests |
| `tests/Feature/Http/QuizControllerTest.php` | Quiz endpoint tests (random question, exclude param) |

---

## Task 1: Project Cleanup & shadcn Init

Remove the starter kit welcome page and auth-related shared props. Initialize shadcn/ui.

**Files:**
- Modify: `routes/web.php`
- Modify: `app/Http/Middleware/HandleInertiaRequests.php`
- Modify: `resources/js/types/global.d.ts`
- Modify: `resources/js/app.tsx`
- Delete: `resources/js/pages/welcome.tsx`
- Delete: `resources/js/types/auth.ts`

- [ ] **Step 1: Initialize shadcn/ui**

Run:
```bash
npx shadcn@latest init -y
```

Accept defaults. This creates `components.json` and sets up the component directory.

- [ ] **Step 2: Add required shadcn components**

Run:
```bash
npx shadcn@latest add card button checkbox badge -y
```

- [ ] **Step 3: Clean up HandleInertiaRequests**

Remove auth from shared props since there's no auth:

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
        ];
    }
}
```

- [ ] **Step 4: Clean up global TypeScript types**

Replace `resources/js/types/global.d.ts`:

```ts
declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            [key: string]: unknown;
        };
    }
}
```

Delete `resources/js/types/auth.ts`.

- [ ] **Step 5: Update app name**

In `.env`, change:
```
APP_NAME="de-dsb Learner"
```

- [ ] **Step 6: Update app.tsx title**

Replace `resources/js/app.tsx`:

```tsx
import { createInertiaApp } from '@inertiajs/react';

createInertiaApp({
    title: (title) => (title ? `${title} - de-dsb Learner` : 'de-dsb Learner'),
    progress: {
        color: '#6b7280',
    },
});
```

- [ ] **Step 7: Clear routes and delete welcome page**

Replace `routes/web.php`:

```php
<?php

use Illuminate\Support\Facades\Route;
```

Delete `resources/js/pages/welcome.tsx`.

- [ ] **Step 8: Run Pint and verify**

Run:
```bash
vendor/bin/pint --dirty --format agent
```

- [ ] **Step 9: Commit**

```bash
git add -A
git commit -m "chore: clean up starter kit, init shadcn/ui, remove auth"
```

---

## Task 2: Database Migrations & Models

Create the three tables and their Eloquent models with relationships and factories.

**Files:**
- Create: `database/migrations/xxxx_create_modules_table.php`
- Create: `database/migrations/xxxx_create_questions_table.php`
- Create: `database/migrations/xxxx_create_answers_table.php`
- Create: `app/Models/Module.php`
- Create: `app/Models/Question.php`
- Create: `app/Models/Answer.php`
- Create: `database/factories/ModuleFactory.php`
- Create: `database/factories/QuestionFactory.php`
- Create: `database/factories/AnswerFactory.php`

- [ ] **Step 1: Create Module model with migration and factory**

Run:
```bash
php artisan make:model Module -mf --no-interaction
```

- [ ] **Step 2: Write the modules migration**

Edit the generated migration:

```php
Schema::create('modules', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

- [ ] **Step 3: Write the Module model**

```php
<?php

namespace App\Models;

use Database\Factories\ModuleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description'])]
class Module extends Model
{
    /** @use HasFactory<ModuleFactory> */
    use HasFactory;

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
```

- [ ] **Step 4: Write the ModuleFactory**

```php
<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Module> */
class ModuleFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
```

- [ ] **Step 5: Create Question model with migration and factory**

Run:
```bash
php artisan make:model Question -mf --no-interaction
```

- [ ] **Step 6: Write the questions migration**

```php
Schema::create('questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('module_id')->constrained()->cascadeOnDelete();
    $table->text('text');
    $table->text('explanation')->nullable();
    $table->string('source')->nullable();
    $table->timestamps();
});
```

- [ ] **Step 7: Write the Question model**

```php
<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['module_id', 'text', 'explanation', 'source'])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
```

- [ ] **Step 8: Write the QuestionFactory**

```php
<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Question> */
class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'text' => fake()->sentence() . '?',
            'explanation' => fake()->paragraph(),
            'source' => fake()->sentence(),
        ];
    }
}
```

- [ ] **Step 9: Create Answer model with migration and factory**

Run:
```bash
php artisan make:model Answer -mf --no-interaction
```

- [ ] **Step 10: Write the answers migration**

```php
Schema::create('answers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('question_id')->constrained()->cascadeOnDelete();
    $table->text('text');
    $table->boolean('is_correct')->default(false);
    $table->timestamps();
});
```

- [ ] **Step 11: Write the Answer model**

```php
<?php

namespace App\Models;

use Database\Factories\AnswerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['question_id', 'text', 'is_correct'])]
class Answer extends Model
{
    /** @use HasFactory<AnswerFactory> */
    use HasFactory;

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
```

- [ ] **Step 12: Write the AnswerFactory**

```php
<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Answer> */
class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'text' => fake()->sentence(),
            'is_correct' => false,
        ];
    }

    public function correct(): static
    {
        return $this->state(['is_correct' => true]);
    }
}
```

- [ ] **Step 13: Run migrations to verify**

Run:
```bash
php artisan migrate --no-interaction
```

Expected: All migrations run successfully.

- [ ] **Step 14: Run Pint**

Run:
```bash
vendor/bin/pint --dirty --format agent
```

- [ ] **Step 15: Commit**

```bash
git add -A
git commit -m "feat: add Module, Question, Answer models with migrations and factories"
```

---

## Task 3: Model Tests

Write Pest feature tests for all model relationships using factories.

**Files:**
- Create: `tests/Feature/Models/ModuleTest.php`
- Create: `tests/Feature/Models/QuestionTest.php`
- Create: `tests/Feature/Models/AnswerTest.php`

- [ ] **Step 1: Create ModuleTest**

Run:
```bash
php artisan make:test --pest Models/ModuleTest --no-interaction
```

Write the test:

```php
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
```

- [ ] **Step 2: Create QuestionTest**

Run:
```bash
php artisan make:test --pest Models/QuestionTest --no-interaction
```

Write the test:

```php
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
```

- [ ] **Step 3: Create AnswerTest**

Run:
```bash
php artisan make:test --pest Models/AnswerTest --no-interaction
```

Write the test:

```php
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
```

- [ ] **Step 4: Run all model tests**

Run:
```bash
php artisan test --compact --filter=Models
```

Expected: All tests pass.

- [ ] **Step 5: Commit**

```bash
git add -A
git commit -m "test: add model relationship tests for Module, Question, Answer"
```

---

## Task 4: TypeScript Types

Define shared TypeScript types for the frontend.

**Files:**
- Create: `resources/js/types/index.ts`

- [ ] **Step 1: Write TypeScript types**

Create `resources/js/types/index.ts`:

```ts
export type Answer = {
    id: number;
    text: string;
    is_correct: boolean;
};

export type Question = {
    id: number;
    text: string;
    explanation: string | null;
    source: string | null;
    answers: Answer[];
};

export type Module = {
    id: number;
    name: string;
    slug: string;
    description: string | null;
    questions_count: number;
};
```

- [ ] **Step 2: Run type check**

Run:
```bash
npm run types:check
```

Expected: No errors.

- [ ] **Step 3: Commit**

```bash
git add resources/js/types/index.ts
git commit -m "feat: add TypeScript types for Module, Question, Answer"
```

---

## Task 5: Module List Controller & Route

Build the controller that serves the module list page.

**Files:**
- Create: `app/Http/Controllers/ModuleController.php`
- Modify: `routes/web.php`
- Create: `tests/Feature/Http/ModuleControllerTest.php`

- [ ] **Step 1: Write the failing test**

Run:
```bash
php artisan make:test --pest Http/ModuleControllerTest --no-interaction
```

Write the test:

```php
<?php

use App\Models\Module;
use App\Models\Question;
use App\Models\Answer;

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
```

- [ ] **Step 2: Run test to verify it fails**

Run:
```bash
php artisan test --compact --filter=ModuleControllerTest
```

Expected: FAIL — route returns wrong component, controller doesn't exist.

- [ ] **Step 3: Create controller**

Run:
```bash
php artisan make:controller ModuleController --no-interaction
```

- [ ] **Step 4: Implement ModuleController::index**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Inertia\Inertia;
use Inertia\Response;

class ModuleController extends Controller
{
    public function index(): Response
    {
        $modules = Module::query()
            ->withCount('questions')
            ->having('questions_count', '>', 0)
            ->orderBy('name')
            ->get();

        return Inertia::render('modules/index', [
            'modules' => $modules,
        ]);
    }
}
```

- [ ] **Step 5: Add route**

Replace `routes/web.php`:

```php
<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
```

- [ ] **Step 6: Create minimal page component so Inertia can render**

Create `resources/js/pages/modules/index.tsx`:

```tsx
import { Head } from '@inertiajs/react';

export default function ModuleIndex() {
    return (
        <>
            <Head title="Module" />
            <div>Module Liste</div>
        </>
    );
}
```

- [ ] **Step 7: Run tests**

Run:
```bash
php artisan test --compact --filter=ModuleControllerTest
```

Expected: All tests pass.

- [ ] **Step 8: Run Pint**

Run:
```bash
vendor/bin/pint --dirty --format agent
```

- [ ] **Step 9: Commit**

```bash
git add -A
git commit -m "feat: add ModuleController with index route, hide empty modules"
```

---

## Task 6: Quiz Controller & Route

Build the controller that serves a random question for a module.

**Files:**
- Create: `app/Http/Controllers/QuizController.php`
- Modify: `routes/web.php`
- Create: `tests/Feature/Http/QuizControllerTest.php`

- [ ] **Step 1: Write the failing tests**

Run:
```bash
php artisan make:test --pest Http/QuizControllerTest --no-interaction
```

Write the tests:

```php
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

it('shuffles answer order', function () {
    $module = Module::factory()->create();
    $question = Question::factory()->for($module)->create();
    Answer::factory(4)->for($question)->sequence(
        ['text' => 'A'],
        ['text' => 'B'],
        ['text' => 'C'],
        ['text' => 'D'],
    )->create();

    // Run multiple times to verify shuffle happens (probabilistic but very reliable with 4 items)
    $orders = collect(range(1, 10))->map(function () use ($module) {
        $response = $this->get("/module/{$module->slug}");
        $data = $response->viewData('page')['props']['question']['answers'];

        return collect($data)->pluck('text')->implode(',');
    })->unique();

    expect($orders->count())->toBeGreaterThan(1);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run:
```bash
php artisan test --compact --filter=QuizControllerTest
```

Expected: FAIL — controller doesn't exist.

- [ ] **Step 3: Create controller**

Run:
```bash
php artisan make:controller QuizController --no-interaction
```

- [ ] **Step 4: Implement QuizController::show**

```php
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

        $query = $module->questions()->with('answers');

        if ($exclude && $module->questions()->count() > 1) {
            $query->where('id', '!=', $exclude);
        }

        $question = $query->inRandomOrder()->firstOrFail();

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
```

- [ ] **Step 5: Add route**

Update `routes/web.php` — add after the existing route:

```php
use App\Http\Controllers\QuizController;

Route::get('/module/{module:slug}', [QuizController::class, 'show'])->name('quiz.show');
```

- [ ] **Step 6: Create minimal quiz page component**

Create `resources/js/pages/modules/quiz.tsx`:

```tsx
import { Head } from '@inertiajs/react';

export default function Quiz() {
    return (
        <>
            <Head title="Quiz" />
            <div>Quiz</div>
        </>
    );
}
```

- [ ] **Step 7: Run tests**

Run:
```bash
php artisan test --compact --filter=QuizControllerTest
```

Expected: All tests pass.

- [ ] **Step 8: Run Pint**

Run:
```bash
vendor/bin/pint --dirty --format agent
```

- [ ] **Step 9: Commit**

```bash
git add -A
git commit -m "feat: add QuizController with random question, exclude, and answer shuffle"
```

---

## Task 7: Module List Page (Frontend)

Build the full module list UI with shadcn Card components.

**Files:**
- Modify: `resources/js/pages/modules/index.tsx`

- [ ] **Step 1: Implement the module list page**

Replace `resources/js/pages/modules/index.tsx`:

```tsx
import { Head, Link } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import type { Module } from '@/types';
import { show } from '@/actions/App/Http/Controllers/QuizController';

type Props = {
    modules: Module[];
};

export default function ModuleIndex({ modules }: Props) {
    return (
        <>
            <Head title="Module" />
            <div className="mx-auto max-w-4xl px-4 py-12">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold tracking-tight">Lernmodule</h1>
                    <p className="mt-2 text-muted-foreground">
                        Wähle ein Modul und teste dein Wissen.
                    </p>
                </div>

                <div className="grid gap-4 sm:grid-cols-2">
                    {modules.map((module) => (
                        <Link
                            key={module.id}
                            href={show.url({ module: module.slug })}
                            className="block"
                        >
                            <Card className="h-full transition-colors hover:bg-accent">
                                <CardHeader>
                                    <div className="flex items-center justify-between">
                                        <CardTitle>{module.name}</CardTitle>
                                        <Badge variant="secondary">
                                            {module.questions_count} {module.questions_count === 1 ? 'Frage' : 'Fragen'}
                                        </Badge>
                                    </div>
                                    {module.description && (
                                        <CardDescription>{module.description}</CardDescription>
                                    )}
                                </CardHeader>
                            </Card>
                        </Link>
                    ))}
                </div>
            </div>
        </>
    );
}
```

- [ ] **Step 2: Generate Wayfinder routes**

Run:
```bash
php artisan wayfinder:generate
```

- [ ] **Step 3: Run type check and lint**

Run:
```bash
npm run types:check && npm run lint
```

Expected: No errors.

- [ ] **Step 4: Commit**

```bash
git add -A
git commit -m "feat: build module list page with shadcn cards and Wayfinder links"
```

---

## Task 8: Quiz Page (Frontend)

Build the full quiz UI with question display, answer selection via checkboxes, checking, feedback, explanation, and navigation.

**Files:**
- Modify: `resources/js/pages/modules/quiz.tsx`

- [ ] **Step 1: Implement the quiz page**

Replace `resources/js/pages/modules/quiz.tsx`:

```tsx
import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { cn } from '@/lib/utils';
import type { Answer, Question } from '@/types';
import { index } from '@/actions/App/Http/Controllers/ModuleController';
import { show } from '@/actions/App/Http/Controllers/QuizController';

type Props = {
    module: {
        id: number;
        name: string;
        slug: string;
    };
    question: Question;
};

export default function Quiz({ module, question }: Props) {
    const [selected, setSelected] = useState<number[]>([]);
    const [checked, setChecked] = useState(false);

    function toggleAnswer(answerId: number) {
        if (checked) return;
        setSelected((prev) =>
            prev.includes(answerId)
                ? prev.filter((id) => id !== answerId)
                : [...prev, answerId],
        );
    }

    function checkAnswers() {
        setChecked(true);
    }

    function nextQuestion() {
        router.visit(show.url({ module: module.slug, _query: { exclude: question.id } }), {
            preserveState: false,
        });
    }

    function answerStyle(answer: Answer): string {
        if (!checked) {
            return selected.includes(answer.id) ? 'border-foreground' : 'border-border';
        }

        if (answer.is_correct) {
            return 'border-emerald-600 bg-emerald-50 dark:bg-emerald-950';
        }

        if (selected.includes(answer.id) && !answer.is_correct) {
            return 'border-red-600 bg-red-50 dark:bg-red-950';
        }

        return 'border-border opacity-60';
    }

    const allCorrectSelected = question.answers
        .filter((a) => a.is_correct)
        .every((a) => selected.includes(a.id));
    const noWrongSelected = selected.every(
        (id) => question.answers.find((a) => a.id === id)?.is_correct,
    );
    const isCorrect = checked && allCorrectSelected && noWrongSelected;

    return (
        <>
            <Head title={`${module.name} - Quiz`} />
            <div className="mx-auto max-w-2xl px-4 py-12">
                <div className="mb-6">
                    <Link
                        href={index.url()}
                        className="text-sm text-muted-foreground hover:text-foreground"
                    >
                        &larr; Zurück zur Modulübersicht
                    </Link>
                    <h1 className="mt-2 text-xl font-semibold">{module.name}</h1>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg font-medium leading-relaxed">
                            {question.text}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="flex flex-col gap-3">
                            {question.answers.map((answer) => (
                                <button
                                    key={answer.id}
                                    type="button"
                                    onClick={() => toggleAnswer(answer.id)}
                                    disabled={checked}
                                    className={cn(
                                        'flex items-center gap-3 rounded-lg border p-4 text-left transition-colors',
                                        !checked && !selected.includes(answer.id) && 'hover:bg-accent',
                                        answerStyle(answer),
                                    )}
                                >
                                    <Checkbox
                                        checked={checked ? answer.is_correct || selected.includes(answer.id) : selected.includes(answer.id)}
                                        disabled={checked}
                                        tabIndex={-1}
                                    />
                                    <span className="text-sm">{answer.text}</span>
                                </button>
                            ))}
                        </div>

                        {checked && (
                            <div className="mt-6">
                                <div className={cn(
                                    'mb-4 rounded-lg p-3 text-sm font-medium',
                                    isCorrect
                                        ? 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200'
                                        : 'bg-red-50 text-red-800 dark:bg-red-950 dark:text-red-200',
                                )}>
                                    {isCorrect ? 'Richtig!' : 'Leider falsch.'}
                                </div>

                                {question.explanation && (
                                    <div className="rounded-lg border bg-muted/50 p-4">
                                        <p className="text-sm leading-relaxed text-muted-foreground">
                                            {question.explanation}
                                        </p>
                                        {question.source && (
                                            <p className="mt-2 text-xs text-muted-foreground/70">
                                                Quelle: {question.source}
                                            </p>
                                        )}
                                    </div>
                                )}
                            </div>
                        )}
                    </CardContent>
                    <CardFooter>
                        {!checked ? (
                            <Button
                                onClick={checkAnswers}
                                disabled={selected.length === 0}
                                className="w-full"
                            >
                                Prüfen
                            </Button>
                        ) : (
                            <Button onClick={nextQuestion} className="w-full">
                                Nächste Frage
                            </Button>
                        )}
                    </CardFooter>
                </Card>
            </div>
        </>
    );
}
```

- [ ] **Step 2: Run type check and lint**

Run:
```bash
npm run types:check && npm run lint
```

Expected: No errors.

- [ ] **Step 3: Build frontend**

Run:
```bash
npm run build
```

Expected: Build succeeds.

- [ ] **Step 4: Commit**

```bash
git add -A
git commit -m "feat: build quiz page with answer selection, checking, and feedback"
```

---

## Task 9: Sample Data Seeder

Create a sample seeder with real-ish Informationssicherheit questions so the app is usable immediately for development and demo.

**Files:**
- Create: `database/seeders/SampleQuestionsSeeder.php`
- Create: `database/migrations/xxxx_seed_sample_questions.php`

- [ ] **Step 1: Create the seeder**

Run:
```bash
php artisan make:seeder SampleQuestionsSeeder --no-interaction
```

Write the seeder:

```php
<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class SampleQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::firstOrCreate(
            ['slug' => 'it-grundschutz'],
            [
                'name' => 'IT-Grundschutz',
                'description' => 'Fragen zum BSI IT-Grundschutz und den zugehörigen Standards.',
            ]
        );

        $questions = [
            [
                'text' => 'Welche Dokumente sind für den Einstieg in den IT-Grundschutz erforderlich oder hilfreich?',
                'explanation' => 'Der BSI-Standard 200-2 beschreibt die IT-Grundschutz-Methodik und das IT-Grundschutz-Kompendium enthält die Bausteine mit Anforderungen. Der BSI-Standard 100-4 ist veraltet (ersetzt durch 200-4) und die BSI TR-03161 behandelt ein anderes Thema.',
                'source' => 'BSI-Standard 200-2, Kapitel 2',
                'answers' => [
                    ['text' => 'BSI-Standard 200-2', 'is_correct' => true],
                    ['text' => 'IT-Grundschutz-Kompendium', 'is_correct' => true],
                    ['text' => 'BSI-Standard 100-4', 'is_correct' => false],
                    ['text' => 'BSI TR-03161', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was beschreibt der BSI-Standard 200-1?',
                'explanation' => 'Der BSI-Standard 200-1 definiert die allgemeinen Anforderungen an ein Managementsystem für Informationssicherheit (ISMS). Er beschreibt nicht die Vorgehensweise der IT-Grundschutz-Methodik (das ist 200-2) und auch nicht das Notfallmanagement (200-4).',
                'source' => 'BSI-Standard 200-1, Einleitung',
                'answers' => [
                    ['text' => 'Anforderungen an ein ISMS', 'is_correct' => true],
                    ['text' => 'Die IT-Grundschutz-Vorgehensweise', 'is_correct' => false],
                    ['text' => 'Notfallmanagement', 'is_correct' => false],
                    ['text' => 'Kryptographische Verfahren', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Schutzbedarfskategorien kennt der IT-Grundschutz?',
                'explanation' => 'Der IT-Grundschutz definiert drei Schutzbedarfskategorien: normal, hoch und sehr hoch. Die Kategorie "kritisch" existiert im IT-Grundschutz nicht.',
                'source' => 'BSI-Standard 200-2, Kapitel 6.2',
                'answers' => [
                    ['text' => 'Normal', 'is_correct' => true],
                    ['text' => 'Hoch', 'is_correct' => true],
                    ['text' => 'Sehr hoch', 'is_correct' => true],
                    ['text' => 'Kritisch', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $answers = $questionData['answers'];
            unset($questionData['answers']);

            $question = Question::create([
                ...$questionData,
                'module_id' => $module->id,
            ]);

            foreach ($answers as $answerData) {
                Answer::create([
                    ...$answerData,
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}
```

- [ ] **Step 2: Create migration that calls the seeder**

Run:
```bash
php artisan make:migration seed_sample_questions --no-interaction
```

Write the migration:

```php
<?php

use Database\Seeders\SampleQuestionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        (new SampleQuestionsSeeder)->run();
    }

    public function down(): void
    {
        // Sample data — no rollback needed
    }
};
```

- [ ] **Step 3: Run migration**

Run:
```bash
php artisan migrate --no-interaction
```

Expected: Migration runs, 3 questions seeded.

- [ ] **Step 4: Verify data**

Run:
```bash
php artisan tinker --execute 'echo App\Models\Module::withCount("questions")->first()->toJson(JSON_PRETTY_PRINT);'
```

Expected: Module with `questions_count: 3`.

- [ ] **Step 5: Run Pint**

Run:
```bash
vendor/bin/pint --dirty --format agent
```

- [ ] **Step 6: Commit**

```bash
git add -A
git commit -m "feat: add sample IT-Grundschutz questions via migration seeder"
```

---

## Task 10: End-to-End Verification & Final Cleanup

Run all tests, verify the full flow, clean up unused files.

**Files:**
- Modify: `database/seeders/DatabaseSeeder.php`

- [ ] **Step 1: Clean up DatabaseSeeder**

Remove the test user creation since we have no auth:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //
    }
}
```

- [ ] **Step 2: Run full test suite**

Run:
```bash
php artisan test --compact
```

Expected: All tests pass.

- [ ] **Step 3: Run frontend checks**

Run:
```bash
npm run types:check && npm run lint:check && npm run format:check
```

Expected: No errors.

- [ ] **Step 4: Build frontend**

Run:
```bash
npm run build
```

Expected: Build succeeds.

- [ ] **Step 5: Run Pint on entire codebase**

Run:
```bash
vendor/bin/pint --format agent
```

- [ ] **Step 6: Verify route list**

Run:
```bash
php artisan route:list --except-vendor
```

Expected output shows two routes:
```
GET / → ModuleController@index (modules.index)
GET /module/{module:slug} → QuizController@show (quiz.show)
```

- [ ] **Step 7: Commit**

```bash
git add -A
git commit -m "chore: final cleanup, remove unused auth seeder"
```

---

## Self-Review Notes

**Spec coverage:** All requirements from the grilling session are covered:
- Module list with question counts, hide empty ✅
- Random question with checkboxes, 1-N correct ✅
- Prüfen button, green/red feedback ✅
- Explanation with source citation ✅
- Nächste Frage stays in module ✅
- Exclude last question from next random ✅
- German UI ✅
- shadcn components ✅
- Neutral colors, color only for right/wrong ✅
- No auth ✅
- Migration-based seeding pattern ✅
- Back link to module list ✅

**Type consistency:** `Module`, `Question`, `Answer` types match across backend props and frontend types. Wayfinder actions match route names (`modules.index`, `quiz.show`). Controller method names match what `make:controller` generates.

**Placeholder scan:** No TBD, TODO, or "implement later" found. All code blocks are complete.
