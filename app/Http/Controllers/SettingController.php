<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_aplikasi' => Setting::get('nama_aplikasi', 'E-Survey Kepuasan Layanan Digital Deli Serdang'),
            'nama_instansi' => Setting::get('nama_instansi', 'Pemerintah Kabupaten Deli Serdang'),
            'alamat_instansi' => Setting::get('alamat_instansi', 'Lubuk Pakam, Deli Serdang, Sumatera Utara'),
            'email_kontak' => Setting::get('email_kontak', 'info@deliserdangkab.go.id'),
            'telepon_kontak' => Setting::get('telepon_kontak', '(061) 7952643'),
            'batas_ikm_a' => Setting::get('batas_ikm_a', '88.31'),
            'batas_ikm_b' => Setting::get('batas_ikm_b', '76.61'),
            'batas_ikm_c' => Setting::get('batas_ikm_c', '65.00'),
            'popup_delay_menit' => Setting::get('popup_delay_menit', '3'),
            'chatbot_link_delay_menit' => Setting::get('chatbot_link_delay_menit', '2'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_aplikasi' => 'required|string|max:200',
            'nama_instansi' => 'required|string|max:200',
            'alamat_instansi' => 'nullable|string|max:255',
            'email_kontak' => 'nullable|email|max:150',
            'telepon_kontak' => 'nullable|string|max:30',
            'batas_ikm_a' => 'required|numeric',
            'batas_ikm_b' => 'required|numeric',
            'batas_ikm_c' => 'required|numeric',
            'popup_delay_menit' => 'required|numeric|min:0',
            'chatbot_link_delay_menit' => 'required|numeric|min:0',
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
