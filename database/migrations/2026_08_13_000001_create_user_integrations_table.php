<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_integrations', function (Blueprint $table) {
            $table->id();

            // 1 akun User = 1 konfigurasi integrasi (relasi one-to-one)
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // === OUTBOUND: kita -> website User (kredensial milik sistem User) ===
            $table->string('api_base_url')->nullable();
            $table->text('api_key')->nullable(); // disimpan terenkripsi (cast 'encrypted')

            // === INBOUND: website User -> kita (kredensial kita generate) ===
            // Disimpan HASH saja (seperti token Sanctum) — token asli cuma ditampilkan
            // 1x saat digenerate/regenerate, supaya lebih aman kalau database bocor.
            $table->string('webhook_token_hash', 64)->nullable()->unique();

            // Status hasil test koneksi outbound terakhir
            $table->enum('status_koneksi', ['belum_terhubung', 'terhubung', 'gagal'])
                ->default('belum_terhubung');
            $table->timestamp('last_tested_at')->nullable();
            $table->text('last_test_message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_integrations');
    }
};
