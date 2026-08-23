<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'nama_aplikasi' => 'E-Survey Kepuasan Layanan Digital Deli Serdang',
            'nama_instansi' => 'Pemerintah Kabupaten Deli Serdang',
            'alamat_instansi' => 'Jl. Karya Wisata, Lubuk Pakam, Deli Serdang, Sumatera Utara',
            'email_kontak' => 'diskominfo@deliserdangkab.go.id',
            'telepon_kontak' => '(061) 7952643',
            'batas_ikm_a' => '88.31',
            'batas_ikm_b' => '76.61',
            'batas_ikm_c' => '65.00',
            'popup_delay_menit' => '3',
            'chatbot_link_delay_menit' => '2',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
