# Question Generation Rules

These rules govern how questions are generated from PDF source material for de-dsb Learner.

## Correctness Guarantee (NON-NEGOTIABLE)

Trust is the product. Every question must be verifiably correct. These rules are absolute.

### The Conservative Principle

- ONLY answers that are CLEARLY and DIRECTLY supported by the source text may be marked `is_correct => true`
- "Clearly supported" means: a human reading only the `quote` can determine that the answer is correct
- If the source text is ambiguous about whether an answer is correct, the answer is NOT correct
- If you are uncertain whether an answer is correct, mark it as INCORRECT
- When in doubt about the entire question, do not include it at all
- It is better to generate 30 high-confidence questions than 50 with shaky correctness

### Verbatim Quote Rules

Every question MUST have a `quote` field containing the VERBATIM text from the source PDF that proves the correct answers are correct. This is the verification anchor.

- Copy the text EXACTLY from the PDF — word for word, including German special characters
- Do NOT paraphrase, summarize, or rephrase the quote
- The quote must be long enough to be unambiguous but short enough to be readable (typically 1-3 sentences)
- If the evidence spans multiple non-adjacent passages, combine them with `[...]` between excerpts
- If you cannot find a verbatim passage that supports the correct answer, DO NOT generate the question

### Source Citation Rules

- `source` field must reference the exact location where the `quote` appears in the original document
- Format: `"{Document Title}, {Chapter/Section}, S. {Page}"`
- Page numbers MUST match where the `quote` text actually appears in the PDF
- If the quote spans pages, cite both: `"S. 42-43"`
- Cross-check: the page number in `source` must be where a reviewer can find the `quote` text
- If you cannot determine the exact page number, cite the chapter/section only and add `(Seitenzahl nicht eindeutig bestimmbar)`

## Workflow

1. User provides a PDF and specifies the target module (or a new module name)
2. Read the PDF, generate questions following the rules below
3. Create a seeder class at `database/seeders/{DocumentName}QuestionsSeeder.php`
4. Create a migration that calls the seeder
5. Run: `php artisan migrate`, `vendor/bin/pint --dirty --format agent`, `php artisan test --compact`
6. Commit: `feat: add {document name} questions to {module name}`

## Seeder Pattern

- Follow the structure of `database/seeders/SampleQuestionsSeeder.php` exactly
- Use `Module::firstOrCreate` by slug (idempotent)
- Self-contained seeder class with inline data (no JSON files)
- Every question MUST include a `quote` field (see Verbatim Quote Rules above)

## Question Data Format

Every question in the seeder array must follow this exact structure:

```php
[
    'text' => 'Die Frage...',
    'explanation' => 'Erklärung mit Bezug zum Originaltext...',
    'quote' => 'Der exakte Wortlaut aus dem Quelldokument...',
    'source' => 'BSI-Standard 200-2, Kapitel X.Y, S. Z',
    'answers' => [
        ['text' => 'Antwort A', 'is_correct' => true],
        ['text' => 'Antwort B', 'is_correct' => false],
        // 3-6 answers total
    ],
],
```

The `quote` field is NOT optional. Omitting it is a generation error.

## Language

- All questions, answers, explanations, quotes, and sources in German

## Question Format

- Flexible number of answer options: 3 to 6, whatever fits the question naturally
- Any number of answers can be correct (1, all, or anything in between)
- Answers are stored unordered (the app shuffles them on display)

## Question Quality

- All questions should be difficult — this is expert-level training, not a beginner quiz
- Test understanding and application, not memorization
- Prefer "Welche...", "Was beschreibt...", "Welche Aussagen treffen zu..." over page-number trivia
- Wrong answers must be highly plausible — close to correct but subtly wrong (wrong version number, outdated term, adjacent concept)
- Use negated questions regularly to force careful reading: "Welche der folgenden Aussagen ist NICHT korrekt?", "Was gehört NICHT zu den..."
- Vary correct-answer counts: some with 1, some with 2-3, some where all are correct

## Explanation

- Should reference the `quote` where relevant — e.g., "Laut dem Standard: '[short excerpt]' — daraus folgt..."
- Must explain why each correct answer is correct, tying back to the quoted source text
- Must explain why each wrong answer is wrong (or at least the key wrong ones)
- Keep it concise but educational — the learner should understand the concept after reading
- Enrichment beyond the source is allowed but must be clearly separated from what the source says

## Volume

- Volume is entirely context-aware — there is no fixed ratio
- Pages with no educational content (table of contents, imprint, blank pages) = 0 questions
- Pages with dense, important content (definitions, requirements, glossary entries) = multiple questions per page
- A single glossary page with 10 terms could produce 5+ questions; a 3-page introduction might produce 1
- For very long PDFs (100+ pages), generate in batches per chapter/section
- Always prefer more high-quality questions over fewer — this is the user's primary study tool
