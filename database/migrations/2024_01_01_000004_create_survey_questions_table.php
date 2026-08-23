<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_template_id')->constrained('survey_templates')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->enum('tipe_jawaban', ['skala_ikm', 'pilihan_ganda', 'isian_singkat', 'esai'])->default('skala_ikm');
            $table->json('opsi_jawaban')->nullable();
            $table->unsignedInteger('urutan')->default(1);
            $table->boolean('wajib_diisi')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('survey_questions'); }
};
