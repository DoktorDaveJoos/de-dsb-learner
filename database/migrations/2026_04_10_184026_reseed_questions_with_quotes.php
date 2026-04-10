<?php

use App\Models\Module;
use Database\Seeders\BsiStandard2002QuestionsSeeder;
use Database\Seeders\SampleQuestionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $module = Module::where('slug', 'it-grundschutz')->first();

        if ($module) {
            $module->questions()->delete();
        }

        (new SampleQuestionsSeeder)->run();
        (new BsiStandard2002QuestionsSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-seeded data — no rollback needed
    }
};
