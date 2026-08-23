<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Menambahkan tipe jawaban baru: rating_bintang (skala 1-5 bintang)
     * Mengecewakan, Kurang, Netral, Baik, Memuaskan
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE survey_questions MODIFY tipe_jawaban ENUM('skala_ikm','pilihan_ganda','rating_bintang','isian_singkat','esai') NOT NULL DEFAULT 'skala_ikm'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE survey_questions MODIFY tipe_jawaban ENUM('skala_ikm','pilihan_ganda','isian_singkat','esai') NOT NULL DEFAULT 'skala_ikm'");
    }
};
