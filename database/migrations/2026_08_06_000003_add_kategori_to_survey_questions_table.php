<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->string('kategori', 150)->nullable()->after('survey_template_id');
        });
    }

    public function down(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
