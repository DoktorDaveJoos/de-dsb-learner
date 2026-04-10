import { Head, Link } from '@inertiajs/react';
import { show } from '@/actions/App/Http/Controllers/QuizController';
import { Badge } from '@/components/ui/badge';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import type { Module } from '@/types';

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
                                            {module.questions_count}{' '}
                                            {module.questions_count === 1 ? 'Frage' : 'Fragen'}
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
