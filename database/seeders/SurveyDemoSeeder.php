<?php

namespace Database\Seeders;

use App\Models\SurveyQuestion;
use App\Models\SurveyTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class SurveyDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('username', 'admin')->first();

        $template = SurveyTemplate::updateOrCreate(['kode_survei' => 'SVY-001'], [
            'judul_survei' => 'Survei Kepuasan Layanan Aplikasi SIPANDU Deli Serdang',
            'unit_layanan' => 'Aplikasi Pelayanan Publik Digital (SIPANDU)',
            'deskripsi' => 'Survei ini bertujuan untuk mengukur tingkat kepuasan masyarakat terhadap layanan digital SIPANDU Kabupaten Deli Serdang.',
            'tanggal_mulai' => now()->subDays(30),
            'tanggal_selesai' => now()->addDays(60),
            'status' => 'aktif',
            'created_by' => $admin?->id,
        ]);

        // Struktur 5 kategori (tahap) sesuai kerangka Kepuasan Pengguna Layanan Digital Pemerintah.
        // Setiap pernyataan menggunakan tipe jawaban rating bintang (1-5).
        $kelompok = [
            'Persyaratan, Biaya, dan Prosedur' => [
                'Bagaimana penilaian Anda terhadap kejelasan persyaratan yang harus dipenuhi dalam layanan ini?',
                'Bagaimana penilaian Anda terhadap kewajaran biaya/tarif dalam layanan ini?',
                'Bagaimana penilaian Anda terhadap kemudahan mekanisme dan prosedur pelayanan?',
            ],
            'Fungsionalitas Layanan Digital' => [
                'Bagaimana penilaian Anda terhadap dukungan layanan digital ini dalam mempercepat urusan Anda?',
                'Bagaimana penilaian Anda terhadap kemampuan layanan digital ini dalam menyelesaikan kebutuhan Anda?',
                'Bagaimana penilaian Anda terhadap kesesuaian layanan ini dengan kebutuhan Anda sebagai pengguna?',
            ],
            'Kualitas Informasi' => [
                'Bagaimana penilaian Anda terhadap akurasi informasi yang disajikan dalam layanan ini?',
                'Bagaimana penilaian Anda terhadap relevansi informasi dengan kebutuhan Anda?',
                'Bagaimana penilaian Anda terhadap kekinian (aktualitas) informasi yang ditampilkan?',
                'Bagaimana penilaian Anda terhadap kelengkapan informasi yang disediakan dalam layanan ini?',
            ],
            'Kualitas Sistem' => [
                'Bagaimana penilaian Anda terhadap keamanan dan perlindungan privasi data Anda dalam layanan ini?',
                'Bagaimana penilaian Anda terhadap personalisasi dan interaktivitas fitur dalam layanan ini?',
                'Bagaimana penilaian Anda terhadap ketersediaan sistem (jarang mengalami gangguan)?',
                'Bagaimana penilaian Anda terhadap kapasitas sistem dalam menangani banyak pengguna sekaligus?',
                'Bagaimana penilaian Anda terhadap tampilan antarmuka (desain) layanan digital ini?',
                'Bagaimana penilaian Anda terhadap kelengkapan sarana dan prasarana pendukung layanan ini?',
            ],
            'Kualitas Layanan' => [
                'Bagaimana penilaian Anda terhadap kemudahan dalam mengakses layanan ini?',
                'Bagaimana penilaian Anda terhadap keandalan (konsistensi kualitas) layanan ini?',
                'Bagaimana penilaian Anda terhadap keberlangsungan layanan ini dalam jangka panjang?',
                'Bagaimana penilaian Anda terhadap kecepatan waktu penyelesaian layanan ini?',
                'Bagaimana penilaian Anda terhadap kompetensi/kemampuan petugas pelaksana layanan?',
                'Bagaimana penilaian Anda terhadap perilaku (keramahan, kesopanan) petugas pelaksana layanan?',
                'Bagaimana penilaian Anda terhadap penanganan pengaduan, saran, dan masukan dalam layanan ini?',
            ],
        ];

        // PENTING: seeder ini dibuat aman untuk dijalankan berkali-kali (idempotent) —
        // pertanyaan yang sudah ada di-update di tempat (ID-nya TIDAK berubah), bukan dihapus-lalu-dibuat-ulang.
        // Ini supaya jawaban responden yang sudah masuk (survey_answers) TIDAK ikut terhapus.
        // Pertanyaan tertentu memakai label bintang kustom (bukan label default
        // "Tidak Sesuai ... Sangat Sesuai"), misalnya pertanyaan biaya/tarif.
        $labelKustom = [
            'Bagaimana penilaian Anda terhadap kewajaran biaya/tarif dalam layanan ini?'
                => ['Mahal', 'Sangat Murah', 'Sesuai', 'Murah', 'Gratis'],
        ];

        $urutan = 1;
        $teksAktif = [];

        foreach ($kelompok as $kategori => $daftarPertanyaan) {
            foreach ($daftarPertanyaan as $teks) {
                SurveyQuestion::updateOrCreate(
                    [
                        'survey_template_id' => $template->id,
                        'pertanyaan' => $teks,
                    ],
                    [
                        'kategori' => $kategori,
                        'tipe_jawaban' => 'rating_bintang',
                        'opsi_jawaban' => $labelKustom[$teks] ?? null,
                        'urutan' => $urutan,
                        'wajib_diisi' => true,
                    ]
                );
                $teksAktif[] = $teks;
                $urutan++;
            }
        }

        // Hapus pertanyaan lama yang sudah tidak dipakai lagi di struktur baru,
        // TAPI hanya yang belum pernah punya jawaban (biar data responden yang sudah masuk aman).
        $template->questions()
            ->whereNotIn('pertanyaan', $teksAktif)
            ->whereDoesntHave('answers')
            ->delete();
    }
}
