<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'api_base_url',
        'api_key',
        'webhook_token_hash',
        'status_koneksi',
        'last_tested_at',
        'last_test_message',
    ];

    protected $casts = [
        'api_key' => 'encrypted',
        'last_tested_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate webhook_token baru (dipanggil saat integrasi pertama kali dibuat
     * atau saat User klik "Generate Ulang Token"). Kembalikan token PLAINTEXT
     * -- ini satu-satunya kesempatan token itu terlihat, jadi harus langsung
     * ditunjukkan/disalin oleh User. Yang tersimpan di DB cuma hash-nya.
     */
    public function generateWebhookToken(): string
    {
        $token = Str::random(64);
        $this->webhook_token_hash = hash('sha256', $token);
        $this->save();

        return $token;
    }

    /**
     * Cek apakah token webhook yang dikirim (dari website User, saat mereka
     * hit endpoint inbound kita) cocok dengan hash yang tersimpan.
     */
    public function verifyWebhookToken(?string $token): bool
    {
        if (!$token || !$this->webhook_token_hash) {
            return false;
        }

        return hash_equals($this->webhook_token_hash, hash('sha256', $token));
    }

    /**
     * Cari integrasi milik User berdasarkan token webhook mentah yang dikirim
     * lewat header. Dipakai oleh WebhookController buat identifikasi + verifikasi
     * sekaligus (mirip cara kerja Sanctum PersonalAccessToken::findToken).
     */
    public static function findByWebhookToken(?string $token): ?self
    {
        if (!$token) {
            return null;
        }

        return static::where('webhook_token_hash', hash('sha256', $token))->first();
    }
}
