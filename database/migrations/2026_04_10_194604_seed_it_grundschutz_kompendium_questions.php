<?php

use Database\Seeders\ItGrundschutzKompendiumQuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new ItGrundschutzKompendiumQuestionsSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Seeded data — no rollback needed
    }
};
