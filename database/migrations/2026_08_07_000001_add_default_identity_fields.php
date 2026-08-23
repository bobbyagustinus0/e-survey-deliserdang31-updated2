<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_identity_fields', function (Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('tipe');
        });

        // Backfill: setiap template survei yang sudah ada diberi field bawaan
        // "Nama Lengkap" dan "Email" agar bisa diedit/dihapus dari admin,
        // sama seperti field tambahan lainnya.
        $templateIds = DB::table('survey_templates')->pluck('id');

        foreach ($templateIds as $templateId) {
            $existingKeys = DB::table('survey_identity_fields')
                ->where('survey_template_id', $templateId)
                ->whereIn('field_key', ['nama_responden', 'email'])
                ->pluck('field_key')
                ->toArray();

            $now = now();

            if (!in_array('nama_responden', $existingKeys)) {
                DB::table('survey_identity_fields')->insert([
                    'survey_template_id' => $templateId,
                    'label' => 'Nama Lengkap',
                    'field_key' => 'nama_responden',
                    'tipe' => 'text',
                    'is_default' => true,
                    'opsi_pilihan' => null,
                    'urutan' => 1,
                    'wajib_diisi' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            if (!in_array('email', $existingKeys)) {
                DB::table('survey_identity_fields')->insert([
                    'survey_template_id' => $templateId,
                    'label' => 'Email',
                    'field_key' => 'email',
                    'tipe' => 'email',
                    'is_default' => true,
                    'opsi_pilihan' => null,
                    'urutan' => 2,
                    'wajib_diisi' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('survey_identity_fields')
            ->where('is_default', true)
            ->whereIn('field_key', ['nama_responden', 'email'])
            ->delete();

        Schema::table('survey_identity_fields', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};
