<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Menyimpan siapa yang mengisi survei jika diisi oleh user yang login
     * (role "Responden" via menu Isi Survey), tetap nullable untuk pengisi publik/anonim.
     */
    public function up(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('survey_template_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
