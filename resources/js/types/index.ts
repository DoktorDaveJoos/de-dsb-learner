export type Answer = {
    id: number;
    text: string;
    is_correct: boolean;
};

export type Question = {
    id: number;
    text: string;
    explanation: string | null;
    quote: string | null;
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
