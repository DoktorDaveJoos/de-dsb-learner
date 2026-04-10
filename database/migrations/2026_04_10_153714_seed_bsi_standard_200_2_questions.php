<?php

use Database\Seeders\BsiStandard2002QuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        (new BsiStandard2002QuestionsSeeder)->run();
    }

    public function down(): void
    {
        // Sample data — no rollback needed
    }
};
