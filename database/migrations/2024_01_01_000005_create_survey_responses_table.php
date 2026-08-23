<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_template_id')->constrained('survey_templates')->cascadeOnDelete();
            $table->string('nama_responden')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('usia')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->decimal('nilai_ikm', 5, 2)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('tanggal_isi')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('survey_responses'); }
};
