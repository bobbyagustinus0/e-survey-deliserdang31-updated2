# API Contract — Integrasi E-Survey ↔ Website User

Dokumen ini adalah acuan resmi buat developer website User yang mengintegrasikan
survei dari platform E-Survey Deli Serdang ke website mereka sendiri.

Ada **dua arah komunikasi, dua kredensial berbeda**:

| Arah | Siapa yang manggil | Kredensial | Dipakai untuk |
|---|---|---|---|
| **Outbound** | Kami → Website Anda | `api_key` (Anda yang isi, dari sistem Anda) | Kami push data survei ke Anda |
| **Inbound** | Website Anda → Kami | `webhook_token` (kami generate, dikasih ke Anda) | Anda kirim jawaban survei ke kami |

Kedua kredensial diatur di menu **Integrasi** pada dashboard admin E-Survey.

> **Catatan implementasi (opsional):** kontrak API di atas tidak mensyaratkan cara Anda
> menyimpan data di sisi Anda. Referensi implementasi untuk Dinsos/Damkar/Disparbud
> menyimpan data yang diterima (`survey_templates` yang di-push, & jawaban sebelum
> diteruskan lewat webhook) ke **database MySQL yang sama** dengan E-Survey
> (`db_survey_deliserdang22`), lewat 2 tabel terpisah: `dinas_survey_cache` dan
> `dinas_survey_jawaban` (lihat `docs/sql/dinas_survey_shared_tables.sql`). Ini murni
> pilihan penyimpanan di sisi website User — **komunikasi antar sistem tetap 100% lewat
> API/webhook seperti didokumentasikan di bawah**, bukan lewat akses database langsung
> antar aplikasi.

---

## 1. Outbound — Kami Push Survei ke Website Anda

Dipicu otomatis setiap kali survei Anda diaktifkan (status diubah jadi `aktif`).

### 1.1 Test Koneksi

```
GET {api_base_url}/ping
Authorization: Bearer {api_key}
Accept: application/json
```

Website Anda cukup merespons status `2xx` (body bebas) supaya dianggap terhubung.

### 1.2 Push Survei

```
POST {api_base_url}/survey
Authorization: Bearer {api_key}
Content-Type: application/json
Accept: application/json
```

**Body:**

```json
{
  "kode_survei": "SVY-001",
  "judul_survei": "Survei Kepuasan Layanan Digital",
  "unit_layanan": "Layanan Perizinan Online",
  "deskripsi": "Mohon isi survei kepuasan setelah menggunakan layanan.",
  "tanggal_mulai": "2026-08-01",
  "tanggal_selesai": "2026-08-31",
  "popup": {
    "tampil_setelah_detik": 3,
    "frekuensi": "sekali_per_sesi",
    "jam_mulai": null,
    "jam_selesai": null
  },
  "field_data_diri": [
    {
      "field_key": "nama_responden",
      "label": "Nama Lengkap",
      "tipe": "text",
      "wajib_diisi": false,
      "opsi_pilihan": null
    },
    {
      "field_key": "usia",
      "label": "Usia",
      "tipe": "angka",
      "wajib_diisi": true,
      "opsi_pilihan": null
    }
  ],
  "pertanyaan": [
    {
      "id": 1,
      "kategori": "Kemudahan Akses",
      "pertanyaan": "Seberapa mudah Anda mengakses layanan ini?",
      "tipe_jawaban": "skala_ikm",
      "opsi_jawaban": null,
      "wajib_diisi": true,
      "urutan": 1
    },
    {
      "id": 5,
      "kategori": "Kepuasan Umum",
      "pertanyaan": "Berikan penilaian bintang untuk layanan kami",
      "tipe_jawaban": "rating_bintang",
      "opsi_jawaban": null,
      "wajib_diisi": true,
      "urutan": 5
    }
  ]
}
```

**Objek `popup`** — dipakai website User untuk mengatur kapan pop up survei ditampilkan ke pengunjung:

| Field | Arti |
|---|---|
| `tampil_setelah_detik` | Jeda (detik) sebelum pop up muncul setelah halaman selesai dimuat. |
| `frekuensi` | `setiap_kunjungan` (selalu muncul), `sekali_per_sesi` (sekali selama tab terbuka), `sekali_per_hari` (sekali per 24 jam), atau `sekali_selamanya` (sekali sampai disubmit/ditutup). |
| `jam_mulai` / `jam_selesai` | Jam (format `HH:mm`) rentang waktu dalam sehari pop up boleh tayang. `null` = tayang sepanjang hari. |

Kombinasi `tanggal_mulai`/`tanggal_selesai` (rentang tanggal) + `popup.jam_mulai`/`popup.jam_selesai` (rentang jam per hari)
+ `popup.frekuensi` (seberapa sering per pengunjung) inilah yang menentukan **kapan** pop up survei muncul secara keseluruhan.

**Tipe field (`field_data_diri[].tipe`):** `text`, `email`, `angka`, `pilihan` (lihat `opsi_pilihan`).

**Tipe jawaban (`pertanyaan[].tipe_jawaban`):**
| Tipe | Format jawaban yang harus dikirim balik saat submit |
|---|---|
| `skala_ikm` | angka 1–4 |
| `rating_bintang` | angka 1–5 |
| `pilihan_ganda` | salah satu isi dari `opsi_jawaban` |
| `teks` | teks bebas |

**Respons yang diharapkan dari website Anda:** status `2xx` = survei berhasil diterima & disimpan/ditampilkan di website Anda. Selain itu dianggap gagal, dan akan tercatat sebagai error di sisi kami (Anda bisa cek status koneksi di menu Integrasi).

> **Tugas developer website User:** implementasikan endpoint `POST {base_url}/survey` ini ("pintu penerima"), simpan datanya, lalu tampilkan survei ke pengunjung website sesuai desain Anda sendiri.

---

## 2. Inbound — Website Anda Kirim Jawaban ke Kami

Setiap kali pengunjung selesai mengisi survei di website Anda, kirim jawabannya ke kami lewat webhook.

```
POST {app_url}/api/webhook/survey-jawaban
X-Webhook-Token: {webhook_token}
Content-Type: application/json
Accept: application/json
```

`{app_url}` adalah alamat aplikasi E-Survey (lihat "Webhook Endpoint" di menu Integrasi Anda).
`{webhook_token}` didapat/di-generate dari menu Integrasi — **simpan baik-baik**, hanya ditampilkan sekali.

**Body:**

```json
{
  "kode_survei": "SVY-001",
  "nama_responden": "Budi Santoso",
  "email": "budi@mail.com",
  "no_hp": "081234567890",
  "data_tambahan": {
    "usia": "25",
    "pekerjaan": "Wiraswasta"
  },
  "jawaban": {
    "1": "4",
    "5": "5"
  }
}
```

Catatan:
- `jawaban` adalah objek `{ "<id_pertanyaan>": "<jawaban>" }` — `id_pertanyaan` mengacu ke `pertanyaan[].id` yang kami kirim saat push survei.
- `data_tambahan` adalah objek `{ "<field_key>": "<nilai>" }` sesuai `field_data_diri` yang kami kirim (di luar `nama_responden`/`email` yang sudah field khusus).
- Field wajib body: `kode_survei`, `jawaban` (minimal 1 jawaban).

**Respons sukses (`201`):**

```json
{
  "success": true,
  "message": "Jawaban survei diterima.",
  "data": {
    "response_id": 123,
    "nilai_ikm": 87.5,
    "kategori": "B (Baik)"
  }
}
```

**Respons gagal:**

| Status | Kapan terjadi |
|---|---|
| `401` | `X-Webhook-Token` tidak ada / salah |
| `404` | `kode_survei` tidak ditemukan, atau bukan milik akun pemilik token tersebut |
| `422` | Survei sudah tidak aktif, atau body tidak valid |

---

## 3. Alur Lengkap (Ringkasan)

1. Superadmin buat akun User.
2. User login → isi `api_base_url` + `api_key` website mereka di menu Integrasi → generate `webhook_token`.
3. Sistem kami test koneksi ke API mereka (`GET {api_base_url}/ping`).
4. User bikin survei → aktifkan.
5. Sistem push data survei ke `{api_base_url}/survey` milik User.
6. Developer website User implementasi "pintu penerima" sesuai dokumen ini, lalu tampilkan survei ke pengunjung.
7. Pengunjung isi survei di website User.
8. Website User kirim webhook (`POST {app_url}/api/webhook/survey-jawaban`) dengan header `X-Webhook-Token`.
9. Jawaban masuk real-time ke database kami → langsung kelihatan di menu Respon Survei / apk mobile.
