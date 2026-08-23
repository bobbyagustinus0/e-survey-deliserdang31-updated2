<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan pengaturan "kapan pop up survei muncul" di website User,
 * supaya jadwal tayang pop up bisa diatur dari dashboard E-Survey
 * (bukan hardcode di kode website masing-masing dinas).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('survey_templates', function (Blueprint $table) {
            // Jeda (detik) sebelum pop up muncul setelah halaman selesai dimuat
            $table->unsignedInteger('popup_tampil_setelah_detik')->default(3)->after('tanggal_selesai');

            // Seberapa sering pop up ditampilkan ke pengunjung yang sama:
            // - setiap_kunjungan : muncul tiap kali buka/refresh halaman
            // - sekali_per_sesi  : muncul sekali selama tab browser masih terbuka
            // - sekali_per_hari  : muncul sekali per 24 jam
            // - sekali_selamanya : muncul sekali saja seumur hidup (sampai cache browser dibersihkan)
            $table->enum('popup_frekuensi', ['setiap_kunjungan', 'sekali_per_sesi', 'sekali_per_hari', 'sekali_selamanya'])
                ->default('sekali_per_sesi')
                ->after('popup_tampil_setelah_detik');

            // Jam mulai & jam selesai tayang pop up dalam sehari (opsional).
            // Kosong = tayang sepanjang hari (selama tanggal_mulai - tanggal_selesai aktif).
            $table->time('popup_jam_mulai')->nullable()->after('popup_frekuensi');
            $table->time('popup_jam_selesai')->nullable()->after('popup_jam_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('survey_templates', function (Blueprint $table) {
            $table->dropColumn(['popup_tampil_setelah_detik', 'popup_frekuensi', 'popup_jam_mulai', 'popup_jam_selesai']);
        });
    }
};
