<?php

use Database\Seeders\IsbModule1QuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        (new IsbModule1QuestionsSeeder)->run();
    }

    public function down(): void
    {
        // Sample data — no rollback needed
    }
};
