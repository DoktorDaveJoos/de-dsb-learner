<?php

use Database\Seeders\SampleQuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

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
