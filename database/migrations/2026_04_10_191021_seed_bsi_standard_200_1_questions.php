<?php

use Database\Seeders\BsiStandard2001QuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new BsiStandard2001QuestionsSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Seeded data — no rollback needed
    }
};
