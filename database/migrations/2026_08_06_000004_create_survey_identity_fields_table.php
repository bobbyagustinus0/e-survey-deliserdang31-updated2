<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_identity_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_template_id')->constrained('survey_templates')->cascadeOnDelete();
            $table->string('label', 150);
            $table->string('field_key', 100); // dipakai sebagai key penyimpanan jawaban, mis. no_hp, instansi
            $table->enum('tipe', ['text', 'email', 'angka', 'pilihan'])->default('text');
            $table->json('opsi_pilihan')->nullable(); // dipakai jika tipe = pilihan
            $table->unsignedInteger('urutan')->default(1);
            $table->boolean('wajib_diisi')->default(false);
            $table->timestamps();

            $table->unique(['survey_template_id', 'field_key']);
        });

        Schema::table('survey_responses', function (Blueprint $table) {
            $table->json('data_tambahan')->nullable()->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_identity_fields');

        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn('data_tambahan');
        });
    }
};
