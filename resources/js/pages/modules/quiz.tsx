import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { index } from '@/actions/App/Http/Controllers/ModuleController';
import { show } from '@/actions/App/Http/Controllers/QuizController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { cn } from '@/lib/utils';
import type { Answer, Question } from '@/types';

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
        if (checked) {
            return;
        }

        setSelected((prev) =>
            prev.includes(answerId) ? prev.filter((id) => id !== answerId) : [...prev, answerId],
        );
    }

    function checkAnswers() {
        setChecked(true);
    }

    function nextQuestion() {
        router.visit(show.url({ module: module.slug }, { query: { exclude: question.id } }), {
            preserveState: false,
        });
    }

    function answerStyle(answer: Answer): string {
        if (!checked) {
            return selected.includes(answer.id) ? 'border-foreground' : 'border-border';
        }

        if (selected.includes(answer.id) && answer.is_correct) {
            return 'border-emerald-600 bg-emerald-50 dark:bg-emerald-950';
        }

        if (selected.includes(answer.id) !== answer.is_correct) {
            return 'border-red-600 bg-red-50 dark:bg-red-950';
        }

        return 'border-border opacity-60';
    }

    const isCorrect =
        checked && question.answers.every((a) => a.is_correct === selected.includes(a.id));

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
                                        'flex items-center gap-3 rounded-lg border p-4 text-left transition-colors cursor-pointer',
                                        !checked &&
                                            !selected.includes(answer.id) &&
                                            'hover:bg-accent',
                                        answerStyle(answer),
                                    )}
                                >
                                    <Checkbox
                                        checked={selected.includes(answer.id)}
                                        disabled={checked}
                                        tabIndex={-1}
                                        className="pointer-events-none"
                                    />
                                    <span className="text-sm">{answer.text}</span>
                                </button>
                            ))}
                        </div>

                        {checked && (
                            <div className="mt-6">
                                <div
                                    className={cn(
                                        'mb-4 rounded-lg p-3 text-sm font-medium',
                                        isCorrect
                                            ? 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200'
                                            : 'bg-red-50 text-red-800 dark:bg-red-950 dark:text-red-200',
                                    )}
                                >
                                    {isCorrect ? 'Richtig!' : 'Leider falsch.'}
                                </div>

                                {(question.explanation || question.quote) && (
                                    <div className="rounded-lg border bg-muted/50 p-4">
                                        {question.quote && (
                                            <p className="text-sm leading-relaxed italic text-muted-foreground">
                                                &bdquo;{question.quote}&ldquo;
                                            </p>
                                        )}
                                        {question.explanation && (
                                            <p
                                                className={cn(
                                                    'text-sm leading-relaxed text-muted-foreground',
                                                    question.quote && 'mt-3',
                                                )}
                                            >
                                                {question.explanation}
                                            </p>
                                        )}
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
                                className="w-full cursor-pointer"
                            >
                                Prüfen
                            </Button>
                        ) : (
                            <Button onClick={nextQuestion} className="w-full cursor-pointer">
                                Nächste Frage
                            </Button>
                        )}
                    </CardFooter>
                </Card>

                <p className="mt-4 text-center text-sm text-muted-foreground">
                    <a
                        href="https://davidjoos.de"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="underline hover:text-foreground"
                    >
                        davidjoos.de
                    </a>
                </p>
            </div>
        </>
    );
}
